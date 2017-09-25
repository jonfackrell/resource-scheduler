@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => ''])
View
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
