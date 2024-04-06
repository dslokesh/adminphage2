
 <!-- Script -->
	<script type="text/javascript">
	$(document).ready(function(){
	var country = "{{old('country_id')?old('country_id'):1}}";
	var oldstate = "{{old('state_id')}}";
	var oldcity = "{{old('city_id')}}";
	$(".india").css("display", "none");
	$(".uae").css("display", "none");
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
		
		$("body #country_id_signup").on("change", function () {
            var country_id = $(this).val();
				if (country_id == 1) {
				$(".india").css("display", "none");
				$(".uae").css("display", "block");
				$("#pan_no, #pan_no_file").attr("required", false);
				$("#trade_license_no, #trade_license_no_file , #trn_no").attr("required", true);
				} else if (country_id == 94) {
				$(".india").css("display", "block");
				$(".uae").css("display", "none");
				$("#pan_no, #pan_no_file").attr("required", true);
				$("#trade_license_no, #trade_license_no_file , #trn_no").attr("required", false);
				}
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
		$("body #country_id_signup").trigger("change");
	}
	
	
	});
	</script>    


