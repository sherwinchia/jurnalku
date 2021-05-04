<div class="">
    <ul>
        <li class="{{ request()->is('admin/dashboard') ? 'navbar-active-list' : 'navbar-list' }}">
            <a class="flex-col justify-between items-center" href="{{ route('admin.dashboard.index') }}">
                <div>
                    <i class="fa fa-home w-8 text-lg"></i>
                    <span class="font-roboto text-md">Dashboard</span>
                </div>
            </a>
        </li>

        <li class="{{ request()->is('admin/users*') ? 'navbar-active-list' : 'navbar-list' }}">
            <a class="flex-col justify-between items-center" href="{{ route('admin.users.index') }}">
                <div>
                    <i class="fa fa-user w-8 text-lg"></i>
                    <span class="font-roboto text-md">User</span>
                </div>
            </a>
        </li>

        <li class="navbar-list pr-0"
            x-data="{contentDrop: {{ request()->is('admin/articles*') ? 'true' : 'false' }}} ">
            <a class="flex-col justify-between items-center cursor-pointer" @click="contentDrop=!contentDrop">
                <div>
                    <i class="fa fa-file-alt w-8 text-lg "></i>
                    <span class="font-roboto text-md">Content</span>
                    <span class="float-right pr-4">
                        <i class="fas fa-caret-down fa-rotate-90" x-show="!contentDrop"></i>
                        <i class="fas fa-caret-down" x-show="contentDrop"></i>
                    </span>
                </div>
            </a>

            <ul class="my-2 transform origin-top-left" x-show="contentDrop"
                x-transition:enter="transition-all ease-out duration-200" x-transition:enter-start="opacity-0 scale-75"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition-all ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-75" x-transition:leave-end="opacity-0 scale-0">
                <li class="{{ request()->is('admin/articles*') ? 'navbar-active-list' : 'navbar-list' }}">
                    <a class="flex-col justify-between items-center " href="">
                        <div class="w-full">
                            <i class="fas fa-newspaper w-8 text-lg "></i>
                            <span class="font-roboto text-md ">Content 1</span>
                        </div>
                    </a>
                </li>
                <li class="{{ request()->is('admin/categories*') ? 'navbar-active-list' : 'navbar-list' }} ">
                    <a class="flex-col justify-between items-center" href="">
                        <div class="w-full">
                            <i class="fas fa-archive w-8 text-lg  "></i>
                            <span class="font-roboto text-md ">Content 2</span>
                        </div>
                    </a>
                </li>
            </ul>
        </li>


        <li class="{{ request()->is('admin/profile*') ? 'navbar-active-list' : 'navbar-list' }}">
            <a class="flex-col justify-between items-center" href="{{ route('admin.profile.show') }}">
                <div class="w-full">
                    <i class="fas fa-user w-8 text-l"></i>
                    <span class="font-roboto text-m">Profile</span>
                </div>
            </a>
        </li>

        <li class="navbar-list">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a onclick="this.parentNode.submit();" class="flex-col justify-between items-center cursor-pointer">
                    <div class="w-full">
                        <i class="fas fa-sign-out-alt w-8 text-l"></i>
                        <span class="font-roboto text-m">Logout</span>
                    </div>
                </a>
            </form>
        </li>
    </ul>
</div>
