
 <!-- Script -->
	<script type="text/javascript">
	$(document).ready(function(){
	var country = "{{old('country_id')}}";
	var oldstate = "{{old('state_id')}}";
	var oldcity = "{{old('city_id')}}";
	
	$("body #country_id").on("change", function () {
            var country_id = $(this).val();
			$("#state_id").prop("disabled",true);
			$("#city_id").prop("disabled",true);
            $.ajax({
                type: "POST",
                url: '{{ route("state.list") }}',
                data: {'country_id': country_id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
					 $('#state_id').html('<option value="">--select--</option>');
					$.each(data, function (key, value) {
                            $("#state_id").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
					$('#state_id').val(oldstate).prop('selected', true);
					$("#state_id").prop("disabled",false);
					$('#city_id').html('<option value="">--select--</option>');
					$("#city_id").prop("disabled",false);
					if(oldstate){
					$("body #state_id").trigger("change");
					}
                }
            });
        });
		
		$("body #state_id").on("change", function () {
            var state_id = $(this).val();
			$("#city_id").prop("disabled",true)
            $.ajax({
                type: "POST",
                url: '{{ route("city.list") }}',
                data: {'state_id': state_id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
					 $('#city_id').html('<option value="">--select--</option>');
					$.each(data, function (key, value) {
                            $("#city_id").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
					$("#city_id").prop("disabled",false);
					$('#city_id').val(oldcity).prop('selected', true);
                }
            });
        });
		
	if(country){
		$("body #country_id").trigger("change");
	}
	
	
	});
	</script>    


