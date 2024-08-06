@include('components.leaveModal')
@include('components.advancePaymentModal')
@include('components.expenditureModal')
@include('components.overTimeModal')

<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('index') }}" class="logo">
            <img src="{{ getCompanyLogo() }}" height="24" alt="logo">
        </a>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item dropdown">
                <button class="nav-link dropdown-toggle leave_btn" type="button" id="requestDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-plus-circle"></i>
                    <span class="item-name">Talep Oluştur</span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="requestDropdown">
                    <li>
                        <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#leaveModal">
                            İzin Talep Et
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#adavancePaymentModal">
                            Avans Talep Et
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#expenditureModal">
                            Harcama Talep Et
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#overTimeModal">
                            Fazla Mesai Talep Et
                        </button>
                    </li>
                </ul>
            </li>

            @foreach($menuItems as $menuItem)
                @if(in_array(\Illuminate\Support\Facades\Auth::user()->user_role, $menuItem['permission']))
                <li class="nav-item {{ Request::routeIs($menuItem['main_route']) ? 'active' : '' }}">
                    <a href="{{ route($menuItem['url']) }}" class="nav-link">
                        <i class="fas fa-layer-group"></i>
                        <span class="item-name">{{ $menuItem['title'] }}</span>
                    </a>
                </li>
                @endif
            @endforeach

            <!-- Diğer menü öğelerini burada ekleyebilirsiniz -->
        </ul>
    </div>
</aside>

