<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- <li class="nav-item">
            <a class="nav-link collapsed" href="">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>
        </li> -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#jobpost-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-newspaper"></i>
                <span>Job Post</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="jobpost-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('EmployerYourJobPosting') }}">
                        <i class="bi bi-circle"></i>
                        <span>View Your Post</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('EmployerAllJobPosting') }}">
                        <i class="bi bi-circle"></i>
                        <span>View All Post</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('JobPostApplicationEmployer') }}">
                <i class="bi bi-clipboard2-fill"></i>
                <span>Application</span>
            </a>
        </li>
       
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('EmployerProfile') }}">
                <i class="bi bi-person-fill"></i>
                <span>Profile</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('EmployerUpgrade') }}">
                <i class="bi bi-currency-exchange"></i>
                <span>Upgrade</span>
            </a>
        </li>
    </ul>

  </aside><!-- End Sidebar-->