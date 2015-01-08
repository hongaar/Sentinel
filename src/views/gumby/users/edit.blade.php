@extends(Config::get('Sentinel::views.layout'))

{{-- Web site Title --}}
@section('title', 'Edit Profile')

{{-- Content --}}
@section('content')
<div class="row">
    <h4>Edit 
        @if ($user->email == Sentry::getUser()->email)
            Your
        @else 
            {{ $user->email }}'s 
        @endif 
        Account</h4>
</div>

@if (! empty($customFields))
<div class="row">
    <ul class="five columns">
        <form method="POST" action="{{ route('sentinel.users.update', $user->id) }}" accept-charset="UTF-8" role="form">

            @foreach(Config::get('Sentinel::auth.additional_user_fields') as $field => $rules)
                <li class="form-group {{ ($errors->has('username')) ? 'danger' : '' }}">
                    <input placeholder="{{ ucwords(str_replace('_',' ',$field)) }}" name="{{ $field }}" type="text" value="{{ $user->$field }}">
                    {{ ($errors->has($field) ? $errors->first($field, '<p class="form_error">:message</p>') : '') }}
                </div>
            @endforeach    
  
            <div class="medium primary btn">
                <input name="_method" value="PUT" type="hidden">
                <input name="_token" value="{{ csrf_token() }}" type="hidden">
                <input name="id" value="{{ $user->id }}" type="hidden">
                <input type="submit" value="Submit Changes">
            </div>    
        </form>
    </ul>
</div>
        
@if (Sentry::getUser()->hasAccess('admin') && ($user->id != Sentry::getUser()->id))
<div class="row">
    <h4>Group Memberships</h4>
    <ul class="five columns push_one">
        <form method="POST" action="{{ route('sentinel.users.memberships', $user->id) }}" accept-charset="UTF-8">
            
            <li class="field">
                @foreach($groups as $group)
                    <label class="checkbox {{ ($user->inGroup($group) ? 'checked' : '') }}">
                        <input type="checkbox" name="groups[{{ $group->name }}]" value="1" {{ ($user->inGroup($group) ? 'checked' : '') }}>
                        {{ $group->name }}
                    </label>
                @endforeach
            </li>

            <div class="medium primary btn">
                <input name="_token" value="{{ csrf_token() }}" type="hidden">
                <input type="submit" value="Update Memberships">
            </div>
        </form>
    </ul>
</div>


<div class="row">
    <h4>Change Password</h4>
    <ul class="six columns">
        <form method="POST" action="{{ route('sentinel.change.password', $user->id) }}" accept-charset="UTF-8">

            @if(! Sentry::getUser()->hasAccess('admin'))
                <li class="field {{ $errors->has('oldPassword') ? 'danger' : '' }}">
                    <input type="password" name="oldPassword" placeholder="New Password" class="password input">
                </li>
                {{ $errors->first('oldPassword',  '<p class="form_error">:message</p>') }}
            @endif

            <li class="field {{ $errors->has('newPassword') ? 'danger' : '' }}">
                <input type="password" name="newPassword" placeholder="New Password" class="password input">
            </li>
            {{ $errors->first('newPassword',  '<p class="form_error">:message</p>') }}

            <li class="field {{ $errors->has('newPassword_confirmation') ? 'danger' : '' }}">
                <input type="password" name="newPassword_confirmation" placeholder="Confirm New Password" class="password input">
            </li>
            {{ $errors->first('newPassword_confirmation',  '<p class="form_error">:message</p>') }}

            <div class="medium primary btn">
                <input name="_token" value="{{ csrf_token() }}" type="hidden">
                <input type="submit" value="Change Password">
            </div>
        </form>
    </ul>
</div>   

@stop