
<style>
.our-team{
    border: 5px solid sienna;
    text-align: center;
    color: #8b2635;
    overflow: hidden;
    transition: all 0.3s ease 0s;
    background: lightgoldenrodyellow;
    border-radius: 10px;
}
.our-team:hover{
    background: BurlyWood;
    color: #fff;
}
.our-team .pic{ position: relative; }
.our-team .pic img{
    width:227px;
    height: 227px;
    transition: all 0.3s ease 0s;
    padding: 10px;
    padding-top: 40px;
}
.our-team:hover .pic img{ transform: translateY(-20px); }
.our-team .social{
    width: 20%;
    height: 100%;
    background: BurlyWood;
    padding: 20px 0;
    margin: 0;
    list-style: none;
    position: absolute;
    top: 0;
    left: -50%;
    transition: all 0.5s ease 0s;
}
.our-team:hover .social{ left: 0; }
.our-team .social li{ display: block; }
.our-team .social li a{
    display: block;
    padding: 10px 0;
    font-size: 20px;
    color: #fff;
    transition: all 0.5s ease 0s;
}
.our-team .social li a:hover{ color: Brown; }
.our-team .team-content{ padding: 25px 0; }
.our-team .title{
    font-size: 15px;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin: 0 0 10px 0;
}
.our-team .post{
    display: block;
    font-size: 15px;
    text-transform: capitalize;
}
@media only screen and (max-width: 990px){
    .our-team{ margin-bottom: 30px; }
}
</style>

<div class="content py-3">
    <div class="card rounded-0 card-outline card-navy shadow" >
        <div class="card-body rounded-0">
            <br />

<center> <h3 style ="font-family: Comic Sans MS;"> DeliPort - where tradition meets technology!</h3> </center><br />
<video width="1085" controls>
  <source src="Deliport.mp4" type="video/mp4">
  <source src="Deliport.ogg" type="video/ogg">
  Your browser does not support HTML video.
</video>
<br /><br /><br /><br />
            <h2 class="text-center">About</h2>
            <center><hr class="bg-navy border-navy w-25 border-2"></center>



            <div>
                <?= file_get_contents("about.html") ?>
            </div>
            <br />
            <h2 class="text-center">Our Team</h2>
            <center><hr class="bg-navy border-navy w-25 border-2"></center>
<br /> <br />
            <div class="container">
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="our-team">
                <div class="pic">
                    <img src="DEVERA.jpg">
                    <ul class="social">
                        <li><a href="#" class="fab fa-facebook"></a></li>
                        <li><a href="#" class="fab fa-google-plus"></a></li>
                        <li><a href="#" class="fab fa-instagram"></a></li>
                        <!--<li><a href="#" class="fab fa-linkedin"></a></li>-->
                    </ul>
                </div>
                <div class="team-content">
                    <h3 class="title">DE VERA, Paul Christian</h3>
                    <span class="post">Project Leader</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="our-team">
                <div class="pic">
                    <img src="ADRANEDA.jpg">
                    <ul class="social">
                        <li><a href="#" class="fab fa-facebook"></a></li>
                        <li><a href="#" class="fab fa-google-plus"></a></li>
                        <li><a href="#" class="fab fa-instagram"></a></li>
                    </ul>
                </div>
                <div class="team-content">
                    <h3 class="title">ADRANEDA, Ruby Ruth</h3>
                    <span class="post">Documenter</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="our-team">
                <div class="pic">
                    <img src="CRUZ.jpg">
                    <ul class="social">
                        <li><a href="#" class="fab fa-facebook"></a></li>
                        <li><a href="#" class="fab fa-google-plus"></a></li>
                        <li><a href="#" class="fab fa-instagram"></a></li>
                    </ul>
                </div>
                <div class="team-content">
                    <h3 class="title">CRUZ, Allyssa</h3>
                    <span class="post">Programmer</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="our-team">
                <div class="pic">
                    <img src="ANGELES.jpg">
                    <ul class="social">
                        <li><a href="#" class="fab fa-facebook"></a></li>
                        <li><a href="#" class="fab fa-google-plus"></a></li>
                        <li><a href="#" class="fab fa-instagram"></a></li>
                    </ul>
                </div>
                <div class="team-content">
                    <h3 class="title">ANGELES, Christian</h3>
                    <span class="post">Reviwer/Tester</span>
                </div>
            </div>
        </div>
    </div>
</div>

<br />
        </div>
    </div>
</div>