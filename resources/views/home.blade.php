@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection























<h1 class="app-page-title">Dashboard</h1>

<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
    <div class="inner">
        <div class="app-card-body p-3 p-lg-4">
            <h3 class="mb-3">Bienvenue!</h3>
            <div class="row gx-5 gy-3">
                <div class="col-12 col-lg-9" style="color: rgb(16, 16, 16)">
                    <div>Soignez les bienvenus dans notre espace de gestion des Employés et des Salaires</div>
                </div><!--//col-->
            </div><!--//row-->
        </div><!--//app-card-body-->
    </div><!--//inner-->
</div><!--//app-card-->

<div class="row g-4 mb-4">
    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1" style="color: green">Total Departements</h4>
                <div class="stats-figure">{{ $totalDepartements }}</div>
                
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                    </svg>
        
            </div><!--//app-card-body-->
            <a class="app-card-link-mask" href="{{route('departements.index')}}" style="color: #4dba0d"></a>
        </div><!--//app-card-->
    </div><!--//col-->

    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1" style="color: green">Totales Employers</h4>
                <div class="stats-figure">{{$totalEmployers}}</div>
               
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                </svg>
                   
            </div><!--//app-card-body-->
            <a class="app-card-link-mask" href="{{route('employers.index')}}" style="color: #4dba0d"></a>
        </div><!--//app-card-->
    </div><!--//col-->

    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1" style="color: green">Total Administrateurs</h4>
                <div class="stats-figure">{{$totalAdministrateurs}}</div>
               
            </div><!--//app-card-body-->
            <a class="app-card-link-mask" href="  " style="color: #4dba0d"></a>
        </div><!--//app-card-->
    </div><!--//col-->

    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1" style="color: green">Total des heures de Travail
                </h4>
                <div class="stats-figure">{{$totalSalaires}}</div>
            </div><!--//app-card-body-->
            <a class="app-card-link-mask" href="{{route('salaries.index')}}" style="color: #4dba0d"></a>
        </div><!--//app-card-->
    </div><!--//col-->

<div class="col-6 col-lg-3">
    <div class="app-card app-card-stat shadow-sm h-100">
        <div class="app-card-body p-3 p-lg-4">
            <h4 class="stats-type mb-1" style="color: green">Total des heures supplémentaires</h4>
            <div class="stats-figure">{{$totalOvertime}}</div>
        </div><!--//app-card-body-->
        <a class="app-card-link-mask" href="{{route('overtime.index')}}" style="color: #4dba0d"></a>
     </div><!--//app-card-->
    </div><!--//col-->

    

<div class="col-6 col-lg-3">
    <div class="app-card app-card-stat shadow-sm h-100">
        <div class="app-card-body p-3 p-lg-4">
            <h4 class="stats-type mb-1" style="color: green">Total des Salaires</h4>
            <div class="stats-figure">{{ number_format($totalSalaires, 2, ',', ' ') }} Fcfa</div>
        </div><!--//app-card-body-->
        <a class="app-card-link-mask" href="{{ route('employers.index')}}" style="color: #4dba0d"></a>
    </div><!--//app-card-->
</div><!--//col-->

<div class="col-6 col-lg-3">
    <div class="app-card app-card-stat shadow-sm h-100">
        <div class="app-card-body p-3 p-lg-4">
            <h4 class="stats-type mb-1" style="color: green">total des Deductions</h4>
            <div class="stats-figure">{{$totalDeductions}}</div>
        </div><!--//app-card-body-->
        <a class="app-card-link-mask" href="{{route('deductions.index')}}" style="color: #4dba0d"></a>
     </div><!--//app-card-->
    </div><!--//col-->

    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1" style="color: green">Retard des paiements</h4>
                <div class="stats-figure">{{$totalDeductions}}</div>
            </div><!--//app-card-body-->
            <a class="app-card-link-mask" href="{{route('deductions.index')}}" style="color: #4dba0d"></a>
         </div><!--//app-card-->
        </div><!--//col-->





        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-6">
                <div class="app-card app-card-progress-list h-100 shadow-sm">
                    <div class="app-card-header p-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <h4 class="app-card-title" style="color: green">Progrès</h4>
                            </div><!--//col-->
                            <div class="col-auto">
                                <div class="card-header-action">
                                    <a href="#">All projects</a>
                                </div><!--//card-header-actions-->
                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//app-card-header-->
                    <div class="app-card-body">
                        <div class="item p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="title mb-1 ">Project lorem ipsum dolor sit amet</div>
                                    <div class="progress">
        <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
                                </div><!--//col-->
                                <div class="col-auto">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
        </svg>
                                </div><!--//col-->
                            </div><!--//row-->
                            <a class="item-link-mask" href="#"></a>
                        </div><!--//item-->
                        
                        
                         <div class="item p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="title mb-1 ">Project duis aliquam et lacus quis ornare</div>
                                    <div class="progress">
        <div class="progress-bar bg-success" role="progressbar" style="width: 34%;" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
                                </div><!--//col-->
                                <div class="col-auto">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
        </svg>
                                </div><!--//col-->
                            </div><!--//row-->
                            <a class="item-link-mask" href="#"></a>
                        </div><!--//item-->
                        
                        <div class="item p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="title mb-1 ">Project sed tempus felis id lacus pulvinar</div>
                                    <div class="progress">
        <div class="progress-bar bg-success" role="progressbar" style="width: 68%;" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
                                </div><!--//col-->
                                <div class="col-auto">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
        </svg>
                                </div><!--//col-->
                            </div><!--//row-->
                            <a class="item-link-mask" href="#"></a>
                        </div><!--//item-->
                        
                        <div class="item p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="title mb-1 ">Project sed tempus felis id lacus pulvinar</div>
                                    <div class="progress">
        <div class="progress-bar bg-success" role="progressbar" style="width: 52%;" aria-valuenow="52" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
                                </div><!--//col-->
                                <div class="col-auto">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
        </svg>
                                </div><!--//col-->
                            </div><!--//row-->
                            <a class="item-link-mask" href="#"></a>
                        </div><!--//item-->
        
                    </div><!--//app-card-body-->
                </div><!--//app-card-->
            </div><!--//col-->
            <div class="col-12 col-lg-6">
                <div class="app-card app-card-stats-table h-100 shadow-sm">
                    <div class="app-card-header p-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <h4 class="app-card-title">Stats List</h4>
                            </div><!--//col-->
                            <div class="col-auto">
                                <div class="card-header-action">
                                    <a href="#">View report</a>
                                </div><!--//card-header-actions-->
                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//app-card-header-->
                    <div class="app-card-body p-3 p-lg-4">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <thead>
                                    <tr>
                                        <th class="meta">Source</th>
                                        <th class="meta stat-cell">Views</th>
                                        <th class="meta stat-cell">Today</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><a href="#">google.com</a></td>
                                        <td class="stat-cell">110</td>
                                        <td class="stat-cell">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up text-success" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                            </svg> 
                                            30%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">getbootstrap.com</a></td>
                                        <td class="stat-cell">67</td>
                                        <td class="stat-cell">23%</td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">w3schools.com</a></td>
                                        <td class="stat-cell">56</td>
                                        <td class="stat-cell">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down text-danger" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                            </svg>
                                            20%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">javascript.com </a></td>
                                        <td class="stat-cell">24</td>
                                        <td class="stat-cell">-</td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">github.com </a></td>
                                        <td class="stat-cell">17</td>
                                        <td class="stat-cell">15%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!--//table-responsive-->
                    </div><!--//app-card-body-->
                </div><!--//app-card-->
            </div><!--//col-->
        </div><!--//row-->
        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-4">
                <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
                    <div class="app-card-header p-3 border-bottom-0">
                        <div class="row align-items-center gx-3">
                            <div class="col-auto">
                                <div class="app-icon-holder">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-receipt" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27zm.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0l-.509-.51z"/>
        <path fill-rule="evenodd" d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z"/>
        </svg>
                                </div><!--//icon-holder-->
                                
                            </div><!--//col-->
                            <div class="col-auto">
                                <h4 class="app-card-title" style="color: green">Invoices</h4>
                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//app-card-header-->
                    <div class="app-card-body px-4">
                        
                        <div class="intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam aliquet eros vel diam semper mollis.</div>
                    </div><!--//app-card-body-->
                    <div class="app-card-footer p-4 mt-auto">
                       <a class="btn app-btn-secondary" href="#">Create New</a>
                    </div><!--//app-card-footer-->
                </div><!--//app-card-->
            </div><!--//col-->
            <div class="col-12 col-lg-4">
                <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
                    <div class="app-card-header p-3 border-bottom-0">
                        <div class="row align-items-center gx-3">
                            <div class="col-auto">
                                <div class="app-icon-holder">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-code-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
        <path fill-rule="evenodd" d="M6.854 4.646a.5.5 0 0 1 0 .708L4.207 8l2.647 2.646a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 0 1 .708 0zm2.292 0a.5.5 0 0 0 0 .708L11.793 8l-2.647 2.646a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708 0z"/>
        </svg>
                                </div><!--//icon-holder-->
                                
                            </div><!--//col-->
                            <div class="col-auto">
                                <h4 class="app-card-title" style="color: green">Apps</h4>
                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//app-card-header-->
                    <div class="app-card-body px-4">
                        
                        <div class="intro">Pellentesque varius, elit vel volutpat sollicitudin, lacus quam efficitur augue</div>
                    </div><!--//app-card-body-->
                    <div class="app-card-footer p-4 mt-auto">
                       <a class="btn app-btn-secondary" href="#">Create New</a>
                    </div><!--//app-card-footer-->
                </div><!--//app-card-->
            </div><!--//col-->
            <div class="col-12 col-lg-4">
                <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
                    <div class="app-card-header p-3 border-bottom-0">
                        <div class="row align-items-center gx-3">
                            <div class="col-auto">
                                <div class="app-icon-holder">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-tools" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M0 1l1-1 3.081 2.2a1 1 0 0 1 .419.815v.07a1 1 0 0 0 .293.708L10.5 9.5l.914-.305a1 1 0 0 1 1.023.242l3.356 3.356a1 1 0 0 1 0 1.414l-1.586 1.586a1 1 0 0 1-1.414 0l-3.356-3.356a1 1 0 0 1-.242-1.023L9.5 10.5 3.793 4.793a1 1 0 0 0-.707-.293h-.071a1 1 0 0 1-.814-.419L0 1zm11.354 9.646a.5.5 0 0 0-.708.708l3 3a.5.5 0 0 0 .708-.708l-3-3z"/>
        <path fill-rule="evenodd" d="M15.898 2.223a3.003 3.003 0 0 1-3.679 3.674L5.878 12.15a3 3 0 1 1-2.027-2.027l6.252-6.341A3 3 0 0 1 13.778.1l-2.142 2.142L12 4l1.757.364 2.141-2.141zm-13.37 9.019L3.001 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z"/>
        </svg>
                                </div><!--//icon-holder-->
                                
                            </div><!--//col-->
                            <div class="col-auto">
                                <h4 class="app-card-title" style="color: green">Tools</h4>
                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//app-card-header-->
                    <div class="app-card-body px-4">
                        
                        <div class="intro">Sed maximus, libero ac pharetra elementum, turpis nisi molestie neque, et tincidunt velit turpis non enim.</div>
                    </div><!--//app-card-body-->
                    <div class="app-card-footer p-4 mt-auto">
                       <a class="btn app-btn-secondary" href="#">Create New</a>
                    </div><!--//app-card-footer-->
                </div><!--//app-card-->
            </div><!--//col-->
        </div><!--//row-->
        



        <h1 class="app-page-title">Dashboard</h1>

<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
    <div class="inner">
        <div class="app-card-body p-3 p-lg-4">
            <h3 class="mb-3">Bienvenue!</h3>
            <div class="row gx-5 gy-3">
                <div class="col-12 col-lg-9" style="color: rgb(16, 16, 16)">
                    <div>Soignez les bienvenus dans notre espace de gestion des Employés et des Salaires</div>
                </div><!--//col-->
            </div><!--//row-->
        </div><!--//app-card-body-->
    </div><!--//inner-->
</div><!--//app-card-->

<div class="row g-4 mb-4">
    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1" style="color: green">Total Departements</h4>
                <div class="stats-figure">{{ $totalDepartements }}</div>
                
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                    </svg>
        
            </div><!--//app-card-body-->
            <a class="app-card-link-mask" href="{{route('departements.index')}}" style="color: #4dba0d"></a>
        </div><!--//app-card-->
    </div><!--//col-->

    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1" style="color: green">Totales Employers</h4>
                <div class="stats-figure">{{$totalEmployers}}</div>
               
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                </svg>
                   
            </div><!--//app-card-body-->
            <a class="app-card-link-mask" href="{{route('employers.index')}}" style="color: #4dba0d"></a>
        </div><!--//app-card-->
    </div><!--//col-->

    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1" style="color: green">Total Administrateurs</h4>
                <div class="stats-figure">{{$totalAdministrateurs}}</div>
               
            </div><!--//app-card-body-->
            <a class="app-card-link-mask" href="  " style="color: #4dba0d"></a>
        </div><!--//app-card-->
    </div><!--//col-->

    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1" style="color: green">Total des heures de Travail
                </h4>
                <div class="stats-figure">{{$totalSalaires}}</div>
            </div><!--//app-card-body-->
            <a class="app-card-link-mask" href="{{route('salaries.index')}}" style="color: #4dba0d"></a>
        </div><!--//app-card-->
    </div><!--//col-->

<div class="col-6 col-lg-3">
    <div class="app-card app-card-stat shadow-sm h-100">
        <div class="app-card-body p-3 p-lg-4">
            <h4 class="stats-type mb-1" style="color: green">Total des heures supplémentaires</h4>
            <div class="stats-figure">{{$totalOvertime}}</div>
        </div><!--//app-card-body-->
        <a class="app-card-link-mask" href="{{route('overtime.index')}}" style="color: #4dba0d"></a>
     </div><!--//app-card-->
    </div><!--//col-->

    

<div class="col-6 col-lg-3">
    <div class="app-card app-card-stat shadow-sm h-100">
        <div class="app-card-body p-3 p-lg-4">
            <h4 class="stats-type mb-1" style="color: green">Total des Salaires</h4>
            <div class="stats-figure">{{ number_format($totalSalaires, 2, ',', ' ') }} Fcfa</div>
        </div><!--//app-card-body-->
        <a class="app-card-link-mask" href="{{ route('employers.index')}}" style="color: #4dba0d"></a>
    </div><!--//app-card-->
</div><!--//col-->

<div class="col-6 col-lg-3">
    <div class="app-card app-card-stat shadow-sm h-100">
        <div class="app-card-body p-3 p-lg-4">
            <h4 class="stats-type mb-1" style="color: green">total des Deductions</h4>
            <div class="stats-figure">{{$totalDeductions}}</div>
        </div><!--//app-card-body-->
        <a class="app-card-link-mask" href="{{route('deductions.index')}}" style="color: #4dba0d"></a>
     </div><!--//app-card-->
    </div><!--//col-->
