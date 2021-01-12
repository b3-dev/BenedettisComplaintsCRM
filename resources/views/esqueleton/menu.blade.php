<?php
use Illuminate\Support\Facades\Route;
$route = Route::getFacadeRoot()->current()->uri();
use App\User;
$arrayMenu = session('SES_USER_MENU');
if(count($arrayMenu)==0)
    return redirect('logout');
?>
<style>
      .activeNav{

          background-color: #CCC;
          border-radius: 25px;

          padding: 3px !important;

      }
    </style>

<ul class="nav flex-column ">

    <h5 class="d-flex justify-content-between px-0 align-items-center mt-3 mb-1 px-3">
        ¡Hola {{ Auth::user()->first_name}}!
    </h5>
    <?php
    foreach ($arrayMenu as $row) :
        $active = ($route==$row->url || $route==$row->app_plus_option_url)?'activeNav':'';
    ?>
        <h6 class="sidebar-heading {{$active}} d-flex justify-content-between px-0 align-items-center mt-3 mb-1 " style="margin:10px !important">
            <a class="nav-link " href="<?= url('/' . $row->url) ?>" >
             {!! @$row->app_html_icon_option !!} {{$row->app_option_name }}
            </a>
            <?php
            $strlen = 0;
            $strlen = @strlen($row->app_plus_option_url);
            if ($strlen > 1 && $row->insert) : ?>
                <a class="d-flex align-items-center pr-3" href="{{$row->app_plus_option_url }}" aria-label="Add {{ $row->app_option_name }}">
                    <i style="font-size:16px;" class="fas fa-plus-circle fa-fw"></i>
                </a>
            <?php endif; ?>
        </h6>
        <?php
        $arraySubMenu = User::getAuthSubmenu($row->auth_id);
        if (!empty($arraySubMenu)) :
            foreach ($arraySubMenu as $rowSubmenu) :
        ?>
                <li class="nav-item px-4">
                    <a class="nav-link text-black-50" href="#">
                        {{ $rowSubmenu->app_suboption_name}}
                    </a>
                </li>
        <?php
            endforeach;
        endif;
        ?>
    <?php
    endforeach;
    ?>
</ul>
<small class="mr-4 float-right">Ver 1.0 </small>


