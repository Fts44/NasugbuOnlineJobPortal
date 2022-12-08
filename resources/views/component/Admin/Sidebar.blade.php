<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('DashboardAdmin') }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('JobPostAdmin') }}">
                <i class="bi bi-newspaper"></i>
                <span>Job Post</span>
            </a>
        </li>

        
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#accounts-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-people-fill"></i>
                <span>Accounts</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="accounts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('AdminAccounts') }}">
                        <i class="bi bi-circle"></i>
                        <span>Employer</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('AccountsApplicant') }}">
                        <i class="bi bi-circle"></i>
                        <span>Applicant</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#upgrade-application-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-currency-exchange"></i>
                <span>Upgrade</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="upgrade-application-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('UpgradeRequest') }}">
                        <i class="bi bi-circle"></i>
                        <span>Request</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('UpgradeValidated') }}">
                        <i class="bi bi-circle"></i>
                        <span>Validated</span>
                    </a>
                </li>
            </ul>
        </li>
     
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#configuration-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-gear-fill"></i>
                <span>Configuration</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="configuration-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('AdminConfigurationJC') }}">
                        <i class="bi bi-circle"></i>
                        <span>Job Category</span>
                    </a>
                </li>
            </ul>
        </li>
        
    </ul>

  </aside><!-- End Sidebar-->