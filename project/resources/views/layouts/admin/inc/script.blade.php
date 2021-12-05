<script type="text/javascript">
		var mainurl = "{{url('/')}}";
		var admin_loader = {{ $gs->is_admin_loader }};
		var whole_sell = {{ $gs->wholesell }};
	</script>

	<!-- Dashboard Core -->
	<script src="{{asset('assets/admin/js/vendors/jquery-1.12.4.min.js')}}"></script>
	<script src="{{asset('assets/admin/js/vendors/bootstrap.min.js')}}"></script>
	<script src="{{asset('assets/admin/js/jqueryui.min.js')}}"></script>
	<!-- Fullside-menu Js-->
	<script src="{{asset('assets/admin/plugins/fullside-menu/jquery.slimscroll.min.js')}}"></script>
	<script src="{{asset('assets/admin/plugins/fullside-menu/waves.min.js')}}"></script>

	<script src="{{asset('assets/admin/js/plugin.js')}}"></script>
	<script src="{{asset('assets/admin/js/Chart.min.js')}}"></script>
	<script src="{{asset('assets/admin/js/tag-it.js')}}"></script>
	<script src="{{asset('assets/admin/js/nicEdit.js')}}"></script>
	<script src="{{asset('assets/admin/js/bootstrap-colorpicker.min.js') }}"></script>
	<script src="{{asset('assets/admin/js/notify.js') }}"></script>

	<script src="{{asset('assets/admin/js/jquery.canvasjs.min.js')}}"></script>

	<script src="{{asset('assets/admin/js/load.js')}}"></script>
	<!-- Custom Js-->
	<script src="{{asset('assets/admin/js/custom.js')}}"></script>
	<!-- AJAX Js-->
	<script src="{{asset('assets/admin/js/myscript.js')}}"></script>
	<script src="{{asset('assets/admin/js/sweet.js')}}"></script>
	
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

	<script>
	    @if(Session::has('rmessage'))
	      var type="{{Session::get('alert-type','info')}}"
	      switch(type){
	          case 'info':
	               toastr.info("{{ Session::get('rmessage') }}");
	               break;
	          case 'success':
	              toastr.success("{{ Session::get('rmessage') }}");
	              break;
	          case 'warning':
	             toastr.warning("{{ Session::get('rmessage') }}");
	              break;
	          case 'error':
	              toastr.error("{{ Session::get('rmessage') }}");
	              break;
	      }
	    @endif
	 </script>

	   <script>  
	   	// delete 
	      $(document).on("click", "#delete", function(e){
	      	
	          e.preventDefault();
	          var link = $(this).attr("href");
	             swal({
	               title: "Are you Want to delete?",
	               text: "Once Delete, This will be Permanently Delete!",
	               icon: "warning",
	               buttons: true,
	               dangerMode: true,
	             })
	             .then((willDelete) => {
	               if (willDelete) {
	                    window.location.href = link;
	               } else {
	                 swal("Safe Data!");
	               }
	             });
	         });
	      // reject
	      $(document).on("click", "#reject", function(e){
	      	
	          e.preventDefault();
	          var link = $(this).attr("href");
	             swal({
	               title: "Are you Want to reject this withdrawal?",
	               text: "",
	               icon: "warning",
	               buttons: true,
	               dangerMode: true,
	             })
	             .then((willDelete) => {
	               if (willDelete) {
	                    window.location.href = link;
	               } else {
	                 swal("Safe withdrawal!");
	               }
	             });
	         });

	      // accept
	       $(document).on("click", ".accept", function(e){
	      	
	          e.preventDefault();
	          var link = $(this).attr("href");
	      
	             swal({
	               title: "Are you Want to accept this withdrawal?",
	               text: "Once Delete, This will be Permanently Delete!",
	               icon: "success",
	               buttons: true,
	               dangerMode: false,
	             })
	             .then((willDelete) => {
	               if (willDelete) {
	                   window.location.href = link;
	                     
	               } else {
	                
	               }  
	             });
	         });
	 </script>

	@yield('scripts')

	@if($gs->is_admin_loader == 0)
	<style>
		div#geniustable_processing {
			display: none !important;
		}
	</style>
	@endif
