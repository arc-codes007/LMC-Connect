@extends('layouts.app')

@section('content')

<section id="home" style="height:100vh">
    <div class="container-fluid h-50 d-flex align-items-center" style="background-image:linear-gradient(-45deg,#9BB1FF,#00A07C); margin-top: -1.1rem;">
        <div class="container py-3">
            <h1 class="display-1 text-white text-center">LMC-Connect</h1>
            <p class="text-center text-white h1">For the Students <br>From the Students</p>
        </div>
    </div>
    <div class="container pt-2 border-bottom" id="about">
        <div class="row justify-content-around">
            <div class="col-lg-6 col-md-12 "><br>
                <h2 class="text-center"><strong>About College</strong></h2>
                <p class="text-left mb-2">
                    <br>
                    Lachoo Memorial College of Science & Technology, a modest creation of the year 1965, has travelled an incredible journey of more than five decades.
                    For concepts savoured by visionary <strong>Shri Mathuradas Mathur</strong>, a connoisseur of higher education in science and technology,
                    this institution has come up synonymous with impeccable academic standards preferred for
                    pursuing multi-disciplinary graduate and post-graduate programmes in the field of
                    science, computers, pharmacy, bio-technolgy and management.
                </p>
            </div><br>
            <div class="col-lg-6 d-none d-lg-block mt-3">
                <img src="{{ asset('images/college_pic.webp.jpg') }}" class="rounded img-fluid" alt="image">
            </div>
        </div>
    </div>
</section>
<section id="features" class="col-lg-12  text-white border-bottom" style="background-image:linear-gradient(-45deg,#0A8DD3,#00A07C);">
    <div class="container py-3 mt-5 ">
        <h2 class="text-center pb-3"><strong>Why Choose Us ?</strong></h2>
        <div class="row text-center">
            <div class="col-md-12">
                <div class="card-body">
                    <h4 class="card-text shadow-sm  d-flex justify-content-center">
                        <i class="fas fa-university fa-lg"></i>
                        <div class="text-center w-75"><strong>LMC-Connect provides a networking platform for students, alumni, and administrators to connect and share ideas for academic and professional development</strong>
                        </div>
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
<section class="bg-warning my-5 p-3">
    <div class="container px-4 text-center">
            <h2 class="text-danger"><strong>Get CONNECTED Now !</strong></h2>
            <h3 class="text-danger">With LMC-Connect</h3>
            <a href="/register" class="btn btn-outline-danger"><strong>Register Now</strong></a>
    </div>
</section>
<section id="footer" class="pt-4 pb-2 border-bottom">
    <div class="container">
        <p class="text-center">Copyright @LMC | Designed for <a href="#" class="text-dark">LMC-Connect</a></p>
    </div>
</section>
@endsection