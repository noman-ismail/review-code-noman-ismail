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
    <script>
    var cropUrl = "{{ route('cropie') }}";
    var userType = "{{ $__userType }}";
    </script>
    <div class="modal fade Death_Modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
              <h4 class="font-weight-600 mb-0">Death Claim Requests Report</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group col-6">
                <label>Death Date From</label>
                <input type="text" class="form-control date_from4" data-toggle="datepicker" id="date-picker6" autocomplete="off">
              </div>
              <div class="form-group col-6">
                <label>Death Date To</label>
                <input type="text" class="form-control date_to4" data-toggle="datepicker" id="date-picker7" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success death-list">Search</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade Expense_Modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
              <h4 class="font-weight-600 mb-0">Expense Sheet Report</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group col-6">
                <label>Death Date From</label>
                <input type="text" class="form-control date_from5" data-toggle="datepicker" id="date-picker8" autocomplete="off">
              </div>
              <div class="form-group col-6">
                <label>Death Date To</label>
                <input type="text" class="form-control date_to5" data-toggle="datepicker" id="date-picker9" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success expense-list">Search</button>
          </div>
        </div>
      </div>
    </div>
    <script>
      $('.death-list').click(function(){
        var date_from = $('.date_from4').val().trim();
        var date_to = $('.date_to4').val().trim();
        var qq = [];
        var i = 0;
        var __ur = '{{ route('death-report') }}';
        // qq += '?dept_id='+dept_id;
        if(date_from != ""){qq[i++] = "date_from="+date_from;}if(date_to != ""){qq[i++] = "date_to="+date_to;}
        __ur += '?'+qq.join('&');
        window.location.href = __ur;
      })
      $('.expense-list').click(function(){
        var date_from = $('.date_from5').val().trim();
        var date_to = $('.date_to5').val().trim();
        var qq = [];
        var i = 0;
        var __ur = '{{ route('expense-report') }}';
        // qq += '?dept_id='+dept_id;
        if(date_from != ""){qq[i++] = "date_from="+date_from;}if(date_to != ""){qq[i++] = "date_to="+date_to;}
        __ur += '?'+qq.join('&');
        window.location.href = __ur;
      })
    </script>
     @php
            $mediaPanel = new \hassankwl1001\mediapanel\Http\Controllers\MediaPanelController;
            echo $mediaPanel->index();
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
          <!--Global script(used by all pages)-->
        <script src="{{ asset("admin-assets/dist/js/popper.min.js")}}"></script>
        <script src="{{ asset("admin-assets/plugins/bootstrap/js/bootstrap.min.js")}}"></script>
        <script src="{{ asset("admin-assets/plugins/metisMenu/metisMenu.min.js")}}"></script>
        <script src="{{ asset("admin-assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js")}}"></script>
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
            $('#date-picker ,#date-picker1 ,#date-picker2 ,#date-picker3 ,#date-picker4 ,#date-picker5 ,#date-picker6 ,#date-picker7 ,#date-picker8 ,#date-picker9 ').samask("00/00/0000");
            $('#mobile').keyup(function(){
                $(this).val($(this).val().replace(/(\d{4})\-?(\d{7})/,'$1-$2'))
            });
            $('#date-picker ,#date-picker1 ,#date-picker2 ,#date-picker3 ,#date-picker4 ,#date-picker5 ,#date-picker6 ,#date-picker7 ,#date-picker8 ,#date-picker9 ').keydown(function(e){
                if ((e.keyCode >= 33 && e.keyCode <= 47) || e.keyCode >= 58 || e.keyCode == 17 ) {
                  return false; 
                }  else {
                  return true;
                } 
            });
        </script>
        <script>
          $('.fa-trash').addClass('text-danger').attr('title','Delete');
          $('.fa-edit').attr('title','Edit');
        </script>
        @if (Request::segment(2)=='dashboard')
           <!-- Third Party Scripts(used by this page)-->
            <script src="{{ asset("admin-assets/plugins/chartJs/Chart.min.js")}}"></script>
            <script src="{{ asset("admin-assets/plugins/apexcharts/dist/apexcharts.min.js")}}"></script>
            <script src="{{ asset("admin-assets/plugins/apexcharts/dist/apexcharts.active.js")}}"></script>
            <script src="{{ asset("admin-assets/plugins/emojionearea/dist/emojionearea.min.js")}}"></script>
           
            <!--Page Active Scripts(used by this page)-->
            <script src="{{ asset("admin-assets/dist/js/pages/home-demo.js")}}"></script>

        @endif
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
        @if (Request::segment(2)=='jobs'  || Request::segment(2)=='blogs' || Request::segment(2)=='news'  )
            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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

@if (Request::segment(2)=='sidebar-settings')
    <script>
        $(document).on("click" , ".check_list" , function(){
            var chk = $(this).is(":checked"); 
            var d = $(this).attr("data-id");
            if (chk){
                var v = $(this).closest("tr").find("th").text();
                var sp = v.split("-");
                var sn = sp[1];
                var li = "<li id='li"+d+"'><b>"+sn+"</b><input type='hidden' name='order[]' value='"+d+"' class='form-control'/><span class='menu-del float-right' data-id='"+d+"'>x</span></li>";
                $(".msortable").append(li);
            }else{
                $(".msortable #li"+d).remove();
            }
        });
         $( document ).ready( function () {
            $(".msortable" ).sortable();
        });
    </script>
@endif
    </body>
</html>