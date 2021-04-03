@extends('Fronted.layouts.master')

@section('title')
    Sign in
@endsection

@section('content')

    <section class="s-header-title" style="background-image: url(/Fronted/img/bg-1-min.png);">
        <div class="container">
            <h1 class="title">Sign in</h1>
            <ul class="breadcrambs">
                <li><a href="/">Home</a></li>
                <li>Sign in</li>
            </ul>
        </div>
    </section>
    <section class="s-about signup">
        <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <form action="signin.php" method="post">

                        <label><b>Email</b></label>
                        <input type="text" placeholder="Email" >
                        <label><b>Password</b></label>
                        <input type="text" placeholder="Password" >
                        <br />
                        <input type="checkbox" checked="checked">Remember


                        <br />
                        <div class="clearfix">
                            <button id="#submit" type="submit" class="btn">Sign In</button>

                        </div>


                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </section>

@endsection
