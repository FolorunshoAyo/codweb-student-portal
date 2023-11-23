<?php
    $curr_page = $_SERVER['SCRIPT_NAME'];

    $script_name = explode("/",$curr_page);

    $script_name = end($script_name);
?>
<div class="mobile-backdrop"></div>
<aside class="dash-menu">
    <div class="logo">
        <div class="menu-icon">
            <i class="fa fa-bars"></i>
            <i class="fa fa-times"></i>
        </div>
        <a href="./">
            <span class="logo-symbol">C</span>
            <span class="logo-text"> CODEWEB </span>
        </a>
    </div>
    <div class="menu-list-container">
        <ul class="side-menu" id="side-menu">
            <li title="dashboard" class="nav-item <?= $script_name === "index.php"? "active" : ""?>">
                <a href="./">
                    <i class="fa fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <span class="nav-pill">&nbsp;</span>
            </li>
            <li title="course info" class="nav-item <?= $script_name === "all-courses.php"? "active" : ""?>">
                <a href="all-courses">
                    <i class="fa fa-bank"></i>
                    <span>All courses</span>
                </a>
                <span class="nav-pill"></span>
            </li>
            <li title="personal details" class="nav-item <?= $script_name === "personal-details.php"? "active" : ""?>">
                <a href="personal-details">
                    <i class="fa fa-user"></i>
                    <span>Personal Details</span>
                </a>
                <span class="nav-pill"></span>
            </li>
            <li title="academic details" class="nav-item <?= $script_name === "academic-details.php"? "active" : ""?>">
                <a href="academic-details">
                    <i class="fa fa-book"></i>
                    <span>Academic Details</span>
                </a>
                <span class="nav-pill"></span>
            </li>
            <li title="finance" class="nav-item <?= $script_name === "finance.php"? "active" : ""?>">
                <a href="finance">
                    <i class="fa fa-money"></i>
                    <span>Finance</span>
                </a>
                <span class="nav-pill"></span>
            </li>
            <li title="course selection" class="nav-item">
                <a href="javascript:void(0)">
                    <i class="fa fa-bars"></i>
                    <span>Course Selection</span>
                </a>
                <span class="nav-pill"></span>
            </li>
            <li title="online exam" class="nav-item">
                <a href="javascript:void(0)">
                    <i class="fa fa-certificate"></i>
                    <span>Online Exam</span>
                </a>
                <span class="nav-pill"></span>
            </li>
        </ul>
    </div>
</aside>