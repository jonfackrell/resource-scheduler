@extends('layouts.public')

@section('title')
    Get A Quote
@endsection

@section('content')
	<div id="app" class="row">
        <div class="col-md-8">
			{!! BootForm::open()->action(route('choose-printer'))->get() !!}
			{!! BootForm::select('Filament', 'filament')->attribute('v-model:value', 'filament')
                            ->options($filaments->pluck('name', 'id'))                           
                            ->helpBlock('This page will automatically reload if you select a new filament.')
             !!}
			{!! BootForm::text('Estimated Time', 'hours')->placeHolder('Nearest Hour')->required()->attribute('v-model:value', 'time') !!}
			{!! BootForm::text('Weight (in grams)', 'weight')->required()->attribute('v-model:value', 'weight') !!}
			{!! BootForm::submit('Upload Your Print')->class('btn btn-block btn-success') !!}
			{!! BootForm::hidden('minutes')->value(0) !!}
			{!! BootForm::close() !!}
		</div>
		<div class="col-md-4"> 
			<h4 id="quote">Input your information for a quote</h4>
		</div>
	</div>
@endsection

@push('custom-scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/collect.js/4.0.26/collect.min.js"></script>
	<script>
		var filaments = collect({!! $filaments->toJson() !!});

		var vm = new Vue({
  			el: '#app',
  			data: {
  				filament: 1,
  				time: "0",
  				weight: "1",
  				quote: "Input your information for a quote"
  			},
  			watch: {
  				filament: function (newFilament, oldFilament) { this.getQuote(); },
  				time: function (newTime, oldTime) { this.getQuote(); },
  				weight: function (newWeight, oldWeight) { this.getQuote(); }
  			},
  			created: function () {
  				this.debouncedGetQuote = _.debounce(this.getQuote, 500);
  			},
  			methods: {
  				getTotal: function () {
  					var pivot = filaments.firstWhere('id',parseInt(this.filament)).pivot;
  					var total = parseInt(this.weight) * ((pivot.cost_per_gram + pivot.add_cost_per_gram) / 100) * pivot.multiplier + (parseInt(this.time) / 12 * 1);
  					return total.toFixed(2);
  				},
  				getQuote: function () {
  					if (this.filament === null){
  						this.quote = "Please choose a filament";
  					}
  					else{
  						if (this.weight < 1 || isNaN(this.weight)){
  							this.weight = 1;
  						}
  						if (isNaN(this.time) || this.time === ""){
  							this.time = 0;
  						}

  						this.quote = "Your quote is: $ " + this.getTotal();
  					}

  					document.getElementById("quote").innerHTML = this.quote;
  					
  				}
  			}
		});
	</script>
@endpush