@component('mail::message')
# Reference Requested from {{ config('app.name') }}

Hi {{ $reference->landlord }},
 
The use `{{ $reference->auth->name }}` wants you to help him/her to find an apartment. 
Please follow the below link and fill the form to help him/her.

@component('mail::button', ['url' => url("references/{$reference->hash}")])
Help To {{ $reference->auth->name }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent