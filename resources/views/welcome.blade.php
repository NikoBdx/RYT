@extends('layouts.app')
@section('content')


<div class="container">
	<div class="text-center mb-3">
		<h1 class="text-script">
			Louez <span class="typewrite" data-period="2000" data-type='[ "une Perceuse...", "une Visseuse...", "un Echafaudage...", "une Bétonnière...", "une Scie Circulaire...", "un Marteau Pneumatique..."]'>
				<span class="wrap"></span>
			</span>
		</h1>
	</div>
    <div class="row">

      <img class= "img-fluid mx-auto d-block logo-welcome" src='{{asset("/img/RYT-logo.png")}}' alt="logo">

	</div>



</div>
<h1 class="text-center Txt-bold mb-4">Les derniers outils proposés</h1>
<div class="card-deck mt-5">
  @foreach ( $tools as $tool)

    <div class="card card-home">
			<a href="/tools/{{ $tool->id }}">
				<img class="card-img-top" src="{{$tool->image}}" class="img-responsive" alt="{{$tool->name}}">
			</a>

					<div class="card-body">
						<a href="/tools/{{ $tool->id }}">
							<h4 class="card-title text-center Txt-bold">{{$tool->title}}</h4>
							<p class="card-text">{{$tool->description}}</p>
						</a>
					</div>


			<a href="/tools/{{ $tool->id }}">
					<div class="card-footer">
						@foreach($tool->categories as $category)
							<span class="categories">{{ $category->name }} </span>
						@endforeach
					</div>
			</a>
		</div>


  @endforeach
</div>


<script>
var TxtType = function(el, toRotate, period) {
        this.toRotate = toRotate;
        this.el = el;
        this.loopNum = 0;
        this.period = parseInt(period, 10) || 2000;
        this.txt = '';
        this.tick();
        this.isDeleting = false;
    };

    TxtType.prototype.tick = function() {
        var i = this.loopNum % this.toRotate.length;
        var fullTxt = this.toRotate[i];

        if (this.isDeleting) {
        this.txt = fullTxt.substring(0, this.txt.length - 1);
        } else {
        this.txt = fullTxt.substring(0, this.txt.length + 1);
        }

        this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

        var that = this;
        var delta = 200 - Math.random() * 100;

        if (this.isDeleting) { delta /= 2; }

        if (!this.isDeleting && this.txt === fullTxt) {
        delta = this.period;
        this.isDeleting = true;
        } else if (this.isDeleting && this.txt === '') {
        this.isDeleting = false;
        this.loopNum++;
        delta = 500;
        }

        setTimeout(function() {
        that.tick();
        }, delta);
    };

    window.onload = function() {
        var elements = document.getElementsByClassName('typewrite');
        for (var i=0; i<elements.length; i++) {
            var toRotate = elements[i].getAttribute('data-type');
            var period = elements[i].getAttribute('data-period');
            if (toRotate) {
              new TxtType(elements[i], JSON.parse(toRotate), period);
            }
        }
        // INJECT CSS
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff}";
        document.body.appendChild(css);
    };

</script>

@endsection
