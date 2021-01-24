@component('mail::message')
# Reference Requested from {{ config('app.name') }}

Hi {{ $reference->landlord }},

The {{ $reference->auth->name }} wanted to help he/his for tenancy.
Please follow the below link and fill the form to help.

@component('mail::button', ['url' => url("references/{$reference->hash}")])
Help To Tenancy
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent