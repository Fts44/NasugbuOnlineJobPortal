<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- <li class="nav-item">
            <a class="nav-link collapsed" href="">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>
        </li> -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('JobPostApplicant') }}">
                <i class="bi bi-newspaper"></i>
                <span>Job Post</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('JobPostApplication') }}">
                <i class="bi bi-clipboard2-fill"></i>
                <span>Application</span>
            </a>
        </li>
       
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('ApplicantProfile') }}">
                <i class="bi bi-person-fill"></i>
                <span>Profile</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('ApplicantUpgrade') }}">
                <i class="bi bi-currency-exchange"></i>
                <span>Upgrade</span>
            </a>
        </li>
    </ul>

  </aside><!-- End Sidebar-->