<div class="row border-bottom">
    <nav class="navbar navbar-static-top bg-danger" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header d-flex">
            <div>
                <a class="navbar-minimalize minimalize-styl-2 btn bg-white" href="#" style="border-color: white;"><i class="fa fa-bars text-danger"></i> </a>
            </div>
            <div class="my-auto ml-2">
                <h4>{{__('menu_wording.title')}}</h4>
            </div>

        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <a href="{{route('admin.logout')}}" class="text-white">
                    <span class="mr-2">Log out</span>
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
</div>