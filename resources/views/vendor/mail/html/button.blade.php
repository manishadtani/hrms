@props(['url', 'color' => 'primary', 'align' => 'center'])

<table class="action" align="{{ $align }}" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="{{ $align }}">
<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="{{ $align }}">
<table border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
<a href="{{ $url }}" class="button button-{{ $color }}" target="_blank" rel="noopener" style="
    display: inline-block;
    padding: 14px 32px;
    border-radius: 12px;
    font-family: 'Inter', Arial, sans-serif;
    font-size: 14px;
    font-weight: 700;
    color: #ffffff;
    text-decoration: none;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    letter-spacing: 0.3px;
    -webkit-text-size-adjust: none;
">{{ $slot }}</a>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
