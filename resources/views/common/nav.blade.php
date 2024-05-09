<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
        <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-5 d-none d-sm-inline">Menu</span>
        </a>
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link align-middle px-0">
                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home Lessons</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('translate.view') }}" class="nav-link align-middle px-0">
                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Translate lesson</span>
                </a>
            </li>
            <li>
                <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                    <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Lessons</span> </a>
                <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                    @forelse($lessons as $key => $lesson)
                        <li class="w-100 ml-20">
                            <a href="{{ route('translate.show', ['id' => $lesson->id ]) }}" class="nav-link px-0"> <span class="d-none d-sm-inline">lesson</span> {{ $key + 1 }} </a>
                        </li>
                    @empty
                    @endforelse
                </ul>
            </li>
        </ul>
    </div>
</div>
