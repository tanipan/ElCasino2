@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@php($dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home'))

@if (config('adminlte.use_route_url', false))
    @php($dashboard_url = $dashboard_url ? route($dashboard_url) : '')
@else
    @php($dashboard_url = $dashboard_url ? url($dashboard_url) : '')
@endif

<a href="#"
    @if ($layoutHelper->isLayoutTopnavEnabled()) class="navbar-brand {{ config('adminlte.classes_brand') }}"
    @else
        class="brand-link {{ config('adminlte.classes_brand') }}" @endif
    style="
        height: 100px;
    ">

    {{-- Small brand logo --}}
    <img src="{{ asset('images/' . ($tema == 1 ? 'logo_su_k.png' : 'logo_su.png')) }}" alt="{{ config('adminlte.logo_img_alt', 'AdminLTE3') }}"
        style="opacity:.8;padding-top: 7px;margin-left: 44px;" height="80px">

    {{-- Brand text --}}
    <span class="brand-text font-weight-light {{ config('adminlte.classes_brand_text') }}">
        &nbsp;
    </span>

</a>
