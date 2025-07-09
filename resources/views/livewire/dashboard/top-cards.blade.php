<div class="col-12"> 
    <div class="row g-lg-2 g-2">
        <div class="col-lg-3 col-sm-6">
            <a href= "{{ {{-- route('dashboard.notviewed') --}} '/dashboard/non-lus' }}" class="card card-sm h-100" >
                <div class="content-text">
                    <div class="row">
                        <div class="col">
                            <div class="mb-2 d-flex justify-content-between align-items-center">
                                <h3>{{ $nb_courriers }}</h3>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h5>Nouveaux courriers</h5>
                            </div>
                           
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-call">
                                <div class="bg" style="background: #29265b;"></div>
                                <i class="fi fi-rr-envelope-download"></i>
                            </div>
                        </div>  
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-sm-6">
            <a href="{{ route('dashboard.running')}}" class="card card-sm h-100">
                <div class="content-text">
                    <div class="row">
                        <div class="col">
                            <div class="mb-2 d-flex justify-content-between align-items-center">
                                <h3>{{ $nb_courriers_t }}</h3>   
                            </div>
                            <div class="d-flex justify-content-between">
                                <h5>Traitement en cours</h5>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-call">
                                <div class="bg" style="background: #e8d052;"></div>
                                <i class="fi fi-rr-hourglass-end"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-sm-6">
            <a href="{{ route('dashboard.late')}}" class="card card-sm h-100" >
                <div class="content-text">
                    <div class="row flex-wrap">
                        <div class="col">
                            <div class="mb-2 d-flex justify-content-between align-items-center">
                                <h3>{{ $nb_courriers_r }}</h3>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h5>Courriers en retard</h5>
                            </div>
                           
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-call">
                                <div class="bg" style="background: #45b3cc;"></div>
                                <i class="fi fi-rr-time-quarter-past"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>


        

        <div class="col-lg-3 col-sm-6">
            <a href="{{ route('dashboard.treated')}}" class="card card-sm h-100" >
                <div class="content-text">
                    <div class="row">
                        <div class="col">
                            <div class="mb-2 d-flex justify-content-between align-items-center">
                                <h3>{{ $nb_courriers_tr }}</h3>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h5>Courriers traités</h5>
                            </div>
                            
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-call">
                                <div class="bg" style="background: #e8d052;"></div>
                                <i class="fi fi-rr-bell-ring"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div> 
    </div>
</div>
    