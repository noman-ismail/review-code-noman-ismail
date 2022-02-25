@php
  $__username = Auth::user()->username;
  $__user = DB::table('admin')->where('username',$__username)->first();
  if($__user){
    $__userType = $__user->type;
  }else{
    $__userType = "";
  }
@endphp
@if ($__userType == 'admin')
  @include('admin.layout.header')
@elseif($__userType == 'province')
  @include('admin.province.layouts.header')
@elseif($__userType == 'national')
  @include('admin.national.layouts.header')
@endif
<link rel="stylesheet" href="{{ asset('assets/style/icomoon.css') }}">
<style>
       .copy-notification {
            color: #ffffff;
            background-color: rgba(0,0,0,0.8);
            padding: 20px;
            border-radius: 30px;
            position: fixed;
            top: 50%;
            left: 50%;
            width: 150px;
            margin-top: -30px;
            margin-left: -85px;
            display: none;
            text-align:center;
            width: auto;
        }
    </style>
</style>
  <script type="text/javascript">

        $(document).ready(function () {
            $(".icomon-tag").click(function (event) {
              var _ic = $(this).find("input[name='icon[]']").val();
                event.preventDefault();
                CopyToClipboard(_ic, true, "Copied to clipboard");
            });
        });

        function CopyToClipboard(value, showNotification, notificationText) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            document.execCommand("copy");
            $temp.remove();

            if (typeof showNotification === 'undefined') {
                showNotification = true;
            }
            if (typeof notificationText === 'undefined') {
                notificationText = "Copied to clipboard";
            }

            var notificationTag = $("div.copy-notification");
            if (showNotification && notificationTag.length == 0) {
                notificationTag = $("<div/>", { "class": "copy-notification", text: notificationText });
                $("body").append(notificationTag);

                notificationTag.fadeIn("slow", function () {
                    setTimeout(function () {
                        notificationTag.fadeOut("slow", function () {
                            notificationTag.remove();
                        });
                    }, 1000);
                });
            }
        }
    </script>
<div class="body-content">
  <div class="row">
    <div class="col-md-12 col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">Icons List</h6>
            </div>
            <div class="text-right">
            </div>
          </div>
        </div>
        <div class="card-body">
           @if (Session::has('flash_message'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! Session('flash_message') !!}</strong>
          </div>
          @endif
           @if (Session::has('flash_message2'))
          <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! Session('flash_message2') !!}</strong>
          </div>
          @endif
          <div class="row">
            <div class="col-12 col-md-6">
              <table class="table">
                <tr>
                  <th>#</th>
                  <th>Tag</th>
                  <th>Icon</th>
                </tr>
                <tr>
                  <td>1</td>
  
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-check_circle_outline"></i>' read-only title='copy to clipboard' >
                  </td>
                  <td class="icomon-icon"><i class="icon-check_circle_outline"></i></td>
                </tr>
                <tr>
                  <td>2</td>
  
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-bars"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-bars"></i></td>
                </tr>
                 <tr>
                  <td>3</td>
        
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-chevron-up"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-chevron-up"></i></td>
                </tr>
                 <tr>
                  <td>4</td>
                    
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-chevron-down"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-chevron-down"></i></td>
                </tr>
                <tr>
                  <td>5</td>
                  
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-bicycle"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-bicycle"></i></td>
                </tr>
                <tr>
                  <td>6</td>
                  
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-automobile"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-automobile"></i></td>
                </tr>
                <tr>
                  <td>7</td>
                
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-car"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-car"></i></td>
                </tr>
                <tr>
                  <td>8</td>
              
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-envelope"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-envelope"></i></td>
                </tr>
                <tr>
                  <td>9</td>
            
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-bell"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-bell"></i></td>
                </tr>
                <tr>
                  <td>10</td>
        
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-angle-double-right"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-angle-double-right"></i></td>
                </tr>
                <tr>
                  <td>11</td>
          
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-chevron-right"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-chevron-right"></i></td>
                </tr>
                <tr>
                  <td>12</td>
          
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-chevron-left"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-chevron-left"></i></td>
                </tr>
                <tr>
                  <td>13</td>
              
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-money"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-money"></i></td>
                </tr>
                <tr>
                  <td>14</td>
        
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-home"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-home"></i></td>
                </tr>
                <tr>
                  <td>15</td>
            
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-office"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-office"></i></td>
                </tr>
                <tr>
                  <td>16</td>
            
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-pencil"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-pencil"></i></td>
                </tr>
                <tr>
                  <td>17</td>
          
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-droplet"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-droplet"></i></td>
                </tr>
                <tr>
                  <td>18</td>
          
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-images"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-images"></i></td>
                </tr>
                <tr>
                  <td>19</td>
        
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-camera"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-camera"></i></td>
                </tr>
                <tr>
                  <td>20</td>
              
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-headphones"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-headphones"></i></td>
                </tr>
                <tr>
                  <td>21</td>
                
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-music"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-music"></i></td>
                </tr>
                <tr>
                  <td>22</td>
            
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-play"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-play"></i></td>
                </tr>
                <tr>
                  <td>23</td>
              
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-bullhorn"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-bullhorn"></i></td>
                </tr>
                <tr>
                  <td>24</td>
            
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-feed"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-feed"></i></td>
                </tr>
                <tr>
                  <td>25</td>
                
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-mic"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-mic"></i></td>
                </tr>
                <tr>
                  <td>26</td>
              
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-book"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-book"></i></td>
                </tr>
                <tr>
                  <td>27</td>
              
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-library"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-library"></i></td>
                </tr>
                <tr>
                  <td>28</td>
            
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-profile"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-profile"></i></td>
                </tr>
                <tr>
                  <td>29</td>
  
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-folder-open"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-folder-open"></i></td>
                </tr>
                <tr>
                  <td>30</td>
  
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-price-tags"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-price-tags"></i></td>
                </tr>
                <tr>
                  <td>31</td>
          
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-coin-dollar"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-coin-dollar"></i></td>
                </tr>
                <tr>
                  <td>32</td>
    
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-credit-card"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-credit-card"></i></td>
                </tr>
                <tr>
                  <td>33</td>
    
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-calculator"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-calculator"></i></td>
                </tr>
                <tr>
                  <td>34</td>
  
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-phone"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-phone"></i></td>
                </tr>
                <tr>
                  <td>35</td>
                
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-pushpin"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-pushpin"></i></td>
                </tr>
                <tr>
                  <td>36</td>
          
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-location"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-location"></i></td>
                </tr>
                <tr>
                  <td>37</td>
        
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-compass"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-compass"></i></td>
                </tr>
                <tr>
                  <td>38</td>
                
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-alarm"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-alarm"></i></td>
                </tr>
                <tr>
                  <td>39</td>
                
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-calendar"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-calendar"></i></td>
                </tr> 
                <tr>
                  <td>40</td>
    
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-printer"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-printer"></i></td>
                </tr> 
                <tr>
                  <td>41</td>
              
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-keyboard"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-keyboard"></i></td>
                </tr> 
                <tr>
                  <td>42</td>
              
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-display"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-display"></i></td>
                </tr> 
                <tr>
                  <td>43</td>
                  
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-mobile"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-mobile"></i></td>
                </tr> 
                <tr>
                  <td>44</td>
              
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-floppy-disk"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-floppy-disk"></i></td>
                </tr> 
                 <tr>
                  <td>45</td>
          
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-user"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-user"></i></td>
                </tr> 
                <tr>
                  <td>46</td>
          
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-users"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-users"></i></td>
                </tr>                 
              </table>
            </div>
            <div class="col-12 col-md-6">
              <table class="table">
                <tr>
                  <th>#</th>
                  <th>Tag</th>
                  <th>Icon</th>
                </tr>
                 
                <tr>
                  <td>47</td>
        
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-user-check"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-user-check"></i></td>
                </tr>
                 <tr>
                  <td>48</td>
          
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-quotes-left"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-quotes-left"></i></td>
                </tr> 
                <tr>
                  <td>49</td>
          
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-quotes-right"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-quotes-right"></i></td>
                </tr> 
                <tr>
                  <td>50</td>
      
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-quotes-left"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-quotes-left"></i></td>
                </tr> 
                <tr>
                  <td>51</td>
            
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-search"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-search"></i></td>
                </tr> 
                <tr>
                  <td>52</td>
            
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-lock"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-lock"></i></td>
                </tr> 
                <tr>
                  <td>53</td>
          
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-gift"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-gift"></i></td>
                </tr> 
                <tr>
                  <td>54</td>
            
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-mug"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-mug"></i></td>
                </tr> 
                <tr>
                  <td>55</td>
        
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-hammer2"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-hammer2"></i></td>
                </tr> 
                <tr>
                  <td>56</td>
            
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-bin"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-bin"></i></td>
                </tr> 
                <tr>
                  <td>57</td>
      
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-briefcase"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-briefcase"></i></td>
                </tr> 
                <tr>
                  <td>58</td>
          
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-airplane"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-airplane"></i></td>
                </tr>
                <tr>
                  <td>59</td>
      
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-truck"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-truck"></i></td>
                </tr><tr>
                  <td>60</td>
                
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-sphere"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-sphere"></i></td>
                </tr><tr>
                  <td>61</td>
              
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-airplane"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-airplane"></i></td>
                </tr><tr>
                  <td>62</td>
              
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-link"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-link"></i></td>
                </tr><tr>
                  <td>63</td>
            
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-flag"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-flag"></i></td>
                </tr><tr>
                  <td>64</td>
                
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-attachment"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-attachment"></i></td>
                </tr>
                <tr>
                  <td>65</td>
                
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-eye"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-eye"></i></td>
                </tr>
                <tr>
                  <td>66</td>
            
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-eye-blocked"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-eye-blocked"></i></td>
                </tr>
                <tr>
                  <td>67</td>
    
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-star-full"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-star-full"></i></td>
                </tr>
                <tr>
                  <td>68</td>
      
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-heart"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-heart"></i></td>
                </tr>                
                <tr>
                  <td>69</td>
          
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-point-right"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-point-right"></i></td>
                </tr>                
                <tr>
                  <td>70</td>
  
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-notification"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-notification"></i></td>
                </tr>                
                <tr>
                  <td>71</td>
    
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-plus"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-plus"></i></td>
                </tr>                
                <tr>
                  <td>72</td>
        
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-minus"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-minus"></i></td>
                </tr>                
                <tr>
                  <td>73</td>
      
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-info"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-info"></i></td>
                </tr>                
                <tr>
                  <td>74</td>
        
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-cancel-circle"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-cancel-circle"></i></td>
                </tr>                
                <tr>
                  <td>75</td>
            
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-heart"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-heart"></i></td>
                </tr>                
                <tr>
                  <td>76</td>
              
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-cross"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-cross"></i></td>
                </tr>                
                <tr>
                  <td>77</td>
            
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-checkmark"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-checkmark"></i></td>
                </tr>                
                <tr>
                  <td>78</td>
              
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-enter"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-enter"></i></td>
                </tr>
                <tr>
                  <td>79</td>
    
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-exit"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-exit"></i></td>
                </tr>
                <tr>
                  <td>80</td>
        
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-arrow-up2"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-arrow-up2"></i></td>
                </tr>
                <tr>
                  <td>81</td>
        
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-arrow-right2"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-arrow-right2"></i></td>
                </tr>
                <tr>
                  <td>82</td>
        
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-arrow-down2"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-arrow-down2"></i></td>
                </tr>
                <tr>
                  <td>83</td>
  
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-arrow-left2"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-arrow-left2"></i></td>
                </tr>
                <tr>
                  <td>84</td>
          
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-facebook"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-facebook"></i></td>
                </tr>
                <tr>
                  <td>85</td>
                
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-instagram"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-instagram"></i></td>
                </tr>
                <tr>
                  <td>86</td>
            
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-whatsapp"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-whatsapp"></i></td>
                </tr>
                <tr>
                  <td>87</td>
            
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-twitter"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-twitter"></i></td>
                </tr>
                <tr>
                  <td>88</td>
          
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-youtube"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-youtube"></i></td>
                </tr> 
                <tr>
                  <td>89</td>
      
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-appleinc"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-appleinc"></i></td>
                </tr> 
                <tr>
                  <td>90</td>
      
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-linkedin2"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-linkedin2"></i></td>
                </tr>
                 <tr>
                  <td>91</td>
              
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-pinterest"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-pinterest"></i></td>
                </tr>
                 <tr>
                  <td>92</td>
            
                  <td class="icomon-tag">
                    <input type="text" class="form-control" name="icon[]" value='<i class="icon-file-pdf"></i>' read-only title='copy to clipboard'>
                  </td>
                  <td class="icomon-icon"><i class="icon-file-pdf"></i></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@if ($__userType == 'admin')
  @include('admin.layout.footer')
@elseif($__userType == 'province')
  @include('admin.province.layouts.footer')
@elseif($__userType == 'national')
  @include('admin.national.layouts.footer')
@else
  @php
      request()->session()->flush();
      $url = route('base_url').'/404';
      echo "<script>
      window.location = '$url';
      </script>";
  @endphp
@endif