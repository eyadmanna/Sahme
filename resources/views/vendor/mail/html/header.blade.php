@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{asset('assets/sahmi/media/logo.jpeg')}}" class="logo" alt="Sahme Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
