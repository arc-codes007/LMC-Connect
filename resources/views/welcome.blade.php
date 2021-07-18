@extends('layouts.app')

@section('content')

<section id="home" class="vh-100">
    <div class="container-fluid" style="background-image:linear-gradient(45deg,#6bc5f7,#1813a5);">
        <div class="container py-3">
            <h1 class="display-3 text-white text-center">LMC-Connect</h1>
            <p class="text-center text-white">For the Students <br>From the Students</p>
        </div>
    </div>
    <div class="container pt-4 pb-4 border-bottom" id="about">
        <div class="row justify-content-around">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <h2 class="text-center"><strong>About College</strong></h2>
                <p class="text-left pt-5">
                    Lachoo Memorial College of Science & Technology, a modest creation of the year 1965, has travelled an incredible journey of more than five decades.
                    For concepts savoured by visionary <strong>Shri Mathuradas Mathur</strong>, a connoisseur of higher education in science and technology,
                    this institution has come up synonymous with impeccable academic standards preferred for
                    pursuing multi-disciplinary graduate and post-graduate programmes in the field of
                    science, computers, pharmacy, bio-technolgy and management.
                </p>
            </div>
            <div class="col-md-6 d-none d-lg-block">
                <img src="/img/college.webp" class="rounded img-fluid" alt="image">
            </div>
        </div>

    </div>
</section>
<section id="features">
    <div class="container px-4 pt-3 pb-4 border-bottom">
        <h2 class="text-center pb-3"><strong>Why Choose Us?</strong></h2>
        <div class="row text-center">
            <div class="col-md-12">
                <div class="card-body">
                    <h4 class="card-text shadow-sm">
                        <p class="text-center"><i class="fas fa-university fa-lg"></i><strong> LMC-Connect is a social platform for interaction of
                                <br> Students and Alumni of Lachoo Memorial College.</strong>
                        </p>
                    </h4>
                </div>
            </div>
        </div>
        <div class="row text-left">
            <div class="col-md-6">
                <div class="card-body">
                    <h4 class="card-text box">
                        <i class="fas fa-map-signs fa-lg"></i> Career Guidance.
                    </h4>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <h4 class="card-text">
                        <i class="fas fa-link fa-lg"></i> Connect with Seniors and Alumni.
                    </h4>
                </div>
            </div>
        </div>
        <div class="row text-left">
            <div class="col-md-6">
                <div class="card-body">
                    <h4 class="card-text">
                        <i class="fas fa-user-graduate fa-lg"></i> Internships Opportunities.
                    </h4>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <h4 class="card-text">
                        <i class="fas fa-user-tie fa-lg"></i> Job Opportunities.
                    </h4>
                </div>
            </div>
        </div>
        <div class="row text-left">
            <div class="col-md-6">
                <div class="card-body">
                    <h4 class="card-text">
                        <i class="fas fa-angle-double-up fa-lg"></i> Skill Enhancement.
                    </h4>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <h4 class="card-text">
                        <i class="fas fa-edit fa-lg"></i> Departmental Updates.
                    </h4>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container px-4 pt-5 pb-5 text-center border-bottom">
        <h3><strong>Get CONNECTED Now !</strong></h3>
        <h4>With LMC-Connect</h4>
        <a href="#" class="btn btn-outline-primary"><strong>Register Now</strong></a>
    </div>
</section>
<section id="footer" class="pt-4 pb-2 border-bottom">
    <div class="container">
        <p class="text-center">Copyright @LMC | Designed for <a href="#">LMC-Connect</a></p>

        <div class="d-flex text-center justify-content-center">
            <a class="pr-2 pl-2" href="#"><i class="fab fa-facebook-f fa-2x"></i></a>
            <a class="pr-2 pl-2" href="#"><i class="fab fa-linkedin fa-2x"></i></a>
            <a class="pr-2 pl-2" href="#"><i class="fab fa-instagram fa-2x"></i></a>

        </div>
    </div>

</section>
@endsection