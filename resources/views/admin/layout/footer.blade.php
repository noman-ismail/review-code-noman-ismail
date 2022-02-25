 <div class="modal fade" id="crop-model" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"> Image Croping</h4>
          <a href="" class="crpMdlHide"><i class="fa fa-times"></i></a>
        </div>
        <div class="modal-body">
          <div class="row div-flex text-center">
            <div class="col-lg-6 crop-sec">
              <div id="dimen" style="margin-bottom: 10px;">
                <label>Width</label> &nbsp;
                <input type="text" id="_width" value="" class="_dm">
                &nbsp; &nbsp; &nbsp;
                <label>Height</label> &nbsp;
                <input type="text" id="_height" value="" class="_dm">
              </div>
              <div class="main-con" id="main-con">
                <div class="u">
                  <div class="img-container">
                    <img id="image" src="image.jpg">
                  </div>
                  <div class="left" style="text-align: center;">
                    <input type="range" class="Zoomer" value="0.2" min="0.1" max="2.5" step="0.01" orient="vertical" style="height: 100%">
                  </div>
                </div>
              </div>
              <div id="btns">
                <input type="button" class="resetData" value="Reset">
                <input type="button" class="Preview" value="Preview">
              </div>
            </div>
            <div class="col-lg-6">
              <div id="crop-imgbox">
                
              </div>
              <div class="text-center updBtn">
                <br> <br>
                <input type='button' id="update" value='Crop & Update'>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @php
        use App\Models\admin;
        $admin = admin::first();
    @endphp
    @php
      $__username = Auth::user()->username;
      $__user = DB::table('admin')->where('username',$__username)->first();
      if($__user){
        $__userType = $__user->type;
      }else{
        $__userType = "";
      }
    @endphp
    <input type="hidden" id="admin_slug" value="{{ $admin->slug }}">
             </div><!--/.main content-->
                <footer class="footer-content">
                    <div class="footer-text d-flex align-items-center justify-content-between">
                        <div class="copy">Powered by: <a href="https://dgaps.com">Digital Applications</a></div>
                    </div>
                </footer><!--/.footer content-->
                <div class="overlay"></div>
            </div><!--/.wrapper-->
        </div>
         <script>
             var _token ="{{csrf_token()}}";
             var seg2 = "{{Request::segment(2)}}";
             var seg3 = "{{Request::segment(3)}}";
            function savenewposition(url,table){
              var position = [];
              $('.updated').each(function(){
                position.push([$(this).attr('data-index'),$(this).attr('data-position')]);
                $(this).removeClass('updated');
              });
              $.ajax({
                url:url,
                method:'POST',
                dataType:'text',
                data:{
                  update:1,
                  table:table,
                  position:position,
                  _token:_token,
                }, success:function(res){
                  console.log(res);
                }, error:function(e){
                  console.log('error'+e);
                }
              });
            }
        </script>
          <!--Global script(used by all pages)-->
        <script src="{{ asset("admin-assets/dist/js/popper.min.js")}}"></script>
        <script src="{{ asset("admin-assets/plugins/bootstrap/js/bootstrap.min.js")}}"></script>
        <script src="{{ asset("admin-assets/plugins/metisMenu/metisMenu.min.js")}}"></script>
        <script src="{{ asset("admin-assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js")}}"></script>
        <script src="{{url('admin-assets/dist/js/cropper.js')}}"></script>
        <link href="{{url('admin-assets/dist/css/cropper.css')}}" rel="stylesheet" type="text/css">
        <script>
          var cropUrl = "{{ route('cropie') }}";
          var userType = "{{ $__userType }}";
          $('.fa-trash').addClass('text-danger').attr('title','Delete');
          $('.fa-edit').attr('title','Edit');
          if ($(window).width() < 514) {
                $('.table').addClass('table-responsive');
            }else{
                $('.table').removeClass('table-responsive');
            }
            $(window).on('resize', function() {
              if ($(window).width() < 514) {
                $('.table').addClass('table-responsive');
              }else{
                $('.table').removeClass('table-responsive');
              }
            });
        </script>
        
        @php
            $mediaPanel = new \hassankwl1001\mediapanel\Http\Controllers\MediaPanelController;
            echo $mediaPanel->index();
        @endphp
            <script src="{{ asset('admin-assets/dist/js/datepicker.min.js') }}"></script>
            <script src="{{ asset('admin-assets/dist/js/chosen.jquery.min.js') }}"></script>
            <script src="{{ asset('admin-assets/dist/js/jquery.samask-masker.min.js') }}"></script>
            <link rel="stylesheet" href="{{ asset('admin-assets/dist/css/component-chosen.min.css') }}">
            <link rel="stylesheet" href="{{ asset('admin-assets/dist/css/datepicker.min.css') }}">
            <script>
                $('[data-toggle="datepicker"]').datepicker({
                    format:'dd/mm/yyyy',
                    zIndex:'9999',
                    autoHide:true,
                });
                $('.form-control-chosen').chosen();
                $('#mobile').samask("0000-0000000");
                $('#date-picker').samask("00/00/0000");
                $('#date-picker1').samask("00/00/0000");
                $('#date-picker2').samask("00/00/0000");
                $('#mobile').keyup(function(){
                    $(this).val($(this).val().replace(/(\d{4})\-?(\d{7})/,'$1-$2'))
                });
                
                // $('#date-picker').keydown(function(e){
                //     if ((e.keyCode >= 33 && e.keyCode <= 47) || e.keyCode >= 58 || e.keyCode == 17 ) {
                //       return true; 
                //     }  else {
                //       return false;
                //     } 
                // });
            </script>
        @if (Request::segment(2)=='blogs' Or Request::segment(2)=='jobs'  Or Request::segment(2)=='news')
           <!-- I-check for checkbox and radio button -->
            <script src="{{ asset("admin-assets/plugins/icheck/icheck.min.js")}}"></script>
            <script src="{{ asset("admin-assets/dist/js/pages/icheck.active.js")}}"></script>
            
        @endif
        @if (Request::segment(2)=='blogs' and Request::segment(3)=='')
           <!-- TagsComplete Plugin -->
           <link rel="stylesheet" href="{{ asset("admin-assets/plugins/tags/tagcomplete.min.css")}}">
            <script src="{{ asset("admin-assets/plugins/tags/tagcomplete.min.js")}}"></script>
            
        @endif
        @if (Request::segment(2)=='homepage' || Request::segment(2)=='footer' || Request::segment(2)=='sidebar-settings' || Request::segment(2)=='authors' || ( Request::segment(2)=='blogs' and Request::segment(3)=='category') )
           <!-- Nestable and dragable list -->
            <script src="{{ asset("admin-assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js")}}"></script>
            <script>
              $( function() {
                 $( "#sortable" ).sortable({
					 update: function( event, ui ) {
						 var n = 0;
						 $("#sortable .row").each(function(){
							 $(this).find(".uc-image").find("input").attr("name", "img"+n);
							 $(this).find(".image_display").attr("id", "img"+n);
							 n++;
						 });
					 },
                 revert: true
                 });
                 $( "#draggable" ).draggable({
                     connectToSortable: "#sortable",
                     helper: "clone",
                     revert: "invalid"
                 });
                 $( "ul, li" ).disableSelection();
             });
            </script>
        @endif
        <!--Page Scripts(used by all page)-->
        <script src="{{ asset("admin-assets/dist/js/sidebar.js")}}"></script>
        <script src="{{ asset("admin-assets/dist/js/custom.js")}}"></script>
        @if (Request::segment(2)=='blogs' || Request::segment(2)=='jobs' || Request::segment(2)=='news'  )
            <script >
            $(document).ready(function(){
               $(".i-check input[type='radio']").on("ifChanged",function(){
                  if($(this).prop("checked") == true){
                    $(this).parent().addClass("iradio_line-green c-checked");
                        $(this).parent().removeClass("iradio_line-grey");
                  }
                  else{
                    $(this).parent().addClass("iradio_line-red");
                        $(this).parent().removeClass("iradio_line-green c-checked");
                  }
                });
    					$(".i-check input[type='checkbox']").on("ifChanged",function(){
    						if($(this).prop("checked") == true){
    							$(this).parent().addClass("icheckbox_line-green c-checked");
                  $(this).parent().removeClass("icheckbox_line-grey");
    						}
    						else{
    							$(this).parent().addClass("icheckbox_line-red");
                  $(this).parent().removeClass("icheckbox_line-green c-checked");
    						}
    					});
				    });
          $(document).ready( function(){
           setTimeout(function(){
              $(".i-check input[type='checkbox']").each(function(){
                  if($(this).prop("checked") == true){
                      var el =  $(this).closest('.i-check').find(".checked");
                      el.addClass(" icheckbox_line-green ");
                      el.removeClass("icheckbox_line-grey");
                  }else{
                      var el =  $(this).closest('.i-check').find(".icheckbox_line-grey");
                      el.addClass(" icheckbox_line-red ");
                      el.removeClass("icheckbox_line-grey");
                  }     
              });
           },200);
              setTimeout(function(){
                 $(".i-check input[type='radio']").each(function(){
                    if($(this).prop("checked") == true){
                        var el =  $(this).closest('.i-check').find(".checked");
                        el.addClass(" iradio_line-green ");
                        el.removeClass("iradio_line-grey");
                    }else{
                        var el =  $(this).closest('.i-check').find(".iradio_line-grey");
                        el.addClass(" iradio_line-red ");
                        el.removeClass("iradio_line-grey");
                    }     
               });
           },200);
          });
      </script>
        @endif
    </body>
</html>