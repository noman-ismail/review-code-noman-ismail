     @php
      $__username = auth('admin')->user()->username;
      $__userType = auth('admin')->user()->type;
      $departs = DB::table('cities')->where('province',auth('admin')->user()->dept_id)->get();
    @endphp
    {{-- {{ route('distribution-report') }} --}}
    <div class="modal fade Distribution_Modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="font-weight-600 mb-0">Budget Distribution Report</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Select Pnael Name</label>
                            <select class="form-control form-control-chosen cities1">
                                <option value="">Choose an Option</option>
                                <option value="pakistan">Pakistan</option>
                                <option value="all">All</option>
                                <option value="current">{{ get_province_name(auth('admin')->user()->dept_id) }}</option>
                                @if (count($departs) > 0)
                                    @foreach ($departs as $val)
                                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label>Select Year</label>
                            <select class="form-control form-control-chosen year1">
                                <option value="">Choose an Option</option>
                                @for ($years = 2021; $years < 2031 ; $years++)
                                  <option value="{{ $years }}">{{ $years }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label>Date From</label>
                            <input type="text" class="form-control date_from1" data-toggle="datepicker" id="date-picker" autocomplete="off">
                        </div>
                        <div class="form-group col-6">
                            <label>Date To</label>
                            <input type="text" class="form-control date_to1" data-toggle="datepicker" id="date-picker1" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success distribution-list">Search</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade Budget_Modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="font-weight-600 mb-0">Budget Requests Report</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label>Select Pnael Name</label>
                            <select class="form-control form-control-chosen cities2">
                                <option value="">Choose an Option</option>
                                <option value="pakistan">Pakistan</option>
                                <option value="all">All</option>
                                <option value="current">{{ get_province_name(auth('admin')->user()->dept_id) }}</option>
                                @if (count($departs) > 0)
                                    @foreach ($departs as $val)
                                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label>Select Year</label>
                            <select class="form-control form-control-chosen year2">
                                <option value="">Choose an Option</option>
                                @for ($years = 2021; $years < 2031 ; $years++)
                                  <option value="{{ $years }}">{{ $years }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label>Date From</label>
                            <input type="text" class="form-control date_from2" data-toggle="datepicker" id="date-picker2" autocomplete="off">
                        </div>
                        <div class="form-group col-6">
                            <label>Date To</label>
                            <input type="text" class="form-control date_to2" data-toggle="datepicker" id="date-picker3" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success request-list">Search</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade Fund_Modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
              <h4 class="font-weight-600 mb-0">Fund Requests Report</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="form-row">
                  <div class="form-group col-12">
                      <label>Select District</label>
                      <select class="form-control form-control-chosen cities3">
                          <option value="">Choose an Option</option>
                          @if (count($departs) > 0)
                              @foreach ($departs as $val)
                                  <option value="{{ $val->id }}">{{ $val->name }}</option>
                              @endforeach
                          @endif
                      </select>
                  </div>
                  <div class="form-group col-12">
                      <label>Select Year</label>
                      <select class="form-control form-control-chosen year3">
                          <option value="">Choose an Option</option>
                          @for ($years = 2021; $years < 2031 ; $years++)
                            <option value="{{ $years }}">{{ $years }}</option>
                          @endfor
                      </select>
                  </div>
                  <div class="form-group col-6">
                      <label>Date From</label>
                      <input type="text" class="form-control date_from3" data-toggle="datepicker" id="date-picker4" autocomplete="off">
                  </div>
                  <div class="form-group col-6">
                      <label>Date To</label>
                      <input type="text" class="form-control date_to3" data-toggle="datepicker" id="date-picker5" autocomplete="off">
                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success fund-list">Search</button>
          </div>
        </div>
      </div>
    </div>
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
              <div class="form-group col-12">
                  <label>Select District</label>
                  <select class="form-control form-control-chosen cities4">
                      <option value="">Choose an Option</option>
                      @if (count($departs) > 0)
                          @foreach ($departs as $val)
                              <option value="{{ $val->id }}">{{ $val->name }}</option>
                          @endforeach
                      @endif
                  </select>
              </div>
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
    var cropUrl = "{{ route('cropie') }}";
    var userType = "{{ $__userType }}";
    </script>
    <input type="hidden" id="admin_slug" value="{{ admin }}">
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
        <script src="{{ asset("admin-assets/dist/js/custom.js")}}"></script>
        <script src="{{ asset("admin-assets/plugins/bootstrap/js/bootstrap.min.js")}}"></script>
        <script src="{{ asset("admin-assets/plugins/metisMenu/metisMenu.min.js")}}"></script>
        <script src="{{ asset("admin-assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js")}}"></script>
        <script>
          $('.fa-trash').addClass('text-danger').attr('title','Delete');
          $('.fa-edit').attr('title','Edit');
        </script>
        <script>
          var dept_id = '{{ auth('admin')->user()->dept_id }}';
          $('.distribution-list').click(function(){
            var panel = $('.cities1').val().trim();
            var year = $('.year1').val().trim();
            var date_from = $('.date_from1').val().trim();
            var date_to = $('.date_to1').val().trim();
            var qq = [];
            var i = 0;
            var __ur = '{{ route('distribution-report') }}';
            // qq += '?dept_id='+dept_id;
            if(panel != ""){qq[i++] = "panel="+panel;}if(year != ""){qq[i++] = "year="+year;}if(date_from != "")
            {qq[i++] = "date_from="+date_from;}if(date_to != ""){qq[i++] = "date_to="+date_to;}
            __ur += '?'+qq.join('&');
            window.location.href = __ur;
          })
          $('.request-list').click(function(){
            var panel = $('.cities2').val().trim();
            var year = $('.year2').val().trim();
            var date_from = $('.date_from2').val().trim();
            var date_to = $('.date_to2').val().trim();
            var qq = [];
            var i = 0;
            var __ur = '{{ route('budget-report') }}';
            // qq += '?dept_id='+dept_id;
            if(panel != ""){qq[i++] = "panel="+panel;}if(year != ""){qq[i++] = "year="+year;}if(date_from != "")
            {qq[i++] = "date_from="+date_from;}if(date_to != ""){qq[i++] = "date_to="+date_to;}
            __ur += '?'+qq.join('&');
            window.location.href = __ur;
          })
          $('.fund-list').click(function(){
            var panel = $('.cities3').val().trim();
            var year = $('.year3').val().trim();
            var date_from = $('.date_from3').val().trim();
            var date_to = $('.date_to3').val().trim();
            var qq = [];
            var i = 0;
            var __ur = '{{ route('fund-report') }}';
            // qq += '?dept_id='+dept_id;
            if(panel != ""){qq[i++] = "panel="+panel;}if(year != ""){qq[i++] = "year="+year;}if(date_from != "")
            {qq[i++] = "date_from="+date_from;}if(date_to != ""){qq[i++] = "date_to="+date_to;}
            __ur += '?'+qq.join('&');
            window.location.href = __ur;
          })
          $('.death-list').click(function(){
            var panel = $('.cities4').val().trim();
            var date_from = $('.date_from4').val().trim();
            var date_to = $('.date_to4').val().trim();
            var qq = [];
            var i = 0;
            var __ur = '{{ route('death-report') }}';
            // qq += '?dept_id='+dept_id;
            if(panel != ""){qq[i++] = "panel="+panel;}if(date_from != "")
            {qq[i++] = "date_from="+date_from;}if(date_to != ""){qq[i++] = "date_to="+date_to;}
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
        @if (Request::segment(2)=='dashboard')
           <!-- Third Party Scripts(used by this page)-->
            <script src="{{ asset("admin-assets/plugins/chartJs/Chart.min.js")}}"></script>
            <script src="{{ asset("admin-assets/plugins/apexcharts/dist/apexcharts.min.js")}}"></script>
            <script src="{{ asset("admin-assets/plugins/apexcharts/dist/apexcharts.active.js")}}"></script>
            <script src="{{ asset("admin-assets/plugins/emojionearea/dist/emojionearea.min.js")}}"></script>
           
            <!--Page Active Scripts(used by this page)-->
            <script src="{{ asset("admin-assets/dist/js/pages/home-demo.js")}}"></script>

        @endif
        <!--Page Scripts(used by all page)-->
        <script src="{{ asset("admin-assets/dist/js/sidebar.js")}}"></script>
        @if (Request::segment(2)=='blogs' Or Request::segment(2)=='jobs' Or Request::segment(2)=='news')
          <script src="{{ asset("admin-assets/plugins/icheck/icheck.min.js")}}"></script>
          <script src="{{ asset("admin-assets/dist/js/pages/icheck.active.js")}}"></script>
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
            $('#date-picker ,#date-picker1 ,#date-picker2 ,#date-picker3 ,#date-picker4 ,#date-picker5 ,#date-picker6 ,#date-picker7 ,#date-picker8 ,#date-picker9 ').samask("00/00/0000");
            $('#mobile').keyup(function(){
                $(this).val($(this).val().replace(/(\d{4})\-?(\d{7})/,'$1-$2'))
            });
            // $('#date-picker ,#date-picker1 ,#date-picker2 ,#date-picker3 ,#date-picker4 ,#date-picker5 ,#date-picker6 ,#date-picker7 ,#date-picker8 ,#date-picker9 ').keydown(function(e){
            //     if ((e.keyCode >= 33 && e.keyCode <= 47) || e.keyCode >= 58 || e.keyCode == 17 ) {
            //       return true; 
            //     }  else {
            //       return false;
            //     } 
            // });
        </script>
        @if (Request::segment(2)=='jobs'  || Request::segment(2)=='blogs'    || Request::segment(2)=='news'  )
            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <script >
               $(document).ready(function(){
                  $('input').on("ifChanged",function(){
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
                 },1000);
               });
            </script>
        @endif
    </body>
</html>