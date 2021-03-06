@extends('design.layout.app')

<?php setlocale(LC_MONETARY, 'es_CO'); ?>


@section('content')
<style type="text/css">
    .ui-autocomplete { max-height: 500px; overflow-y: scroll; overflow-x: hidden; margin-left:-50px;}
</style>

<style type="text/css">

  #upload-btn {
    position: relative;
    margin: auto;
    font-family: calibri;
    width: 250px;
    padding: 10px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border: 1px dashed #BBB;
    text-align: center;
    /*background-color: #DDD;*/
    cursor: pointer;
  }
</style>

<main>
  <div class="cart-section p-3">
    <div class="row justify-content-center p-3">
      <h1 class="display-4 dra-color cart-title p-3">
        Carrito de Compras
      </h1>
    </div>
    <div class="row">
      <div class="col-md-4 p-4">
          <div class="dra-box">
              <h3 class="mb-4">Buscar</h3>
              <form action="" class="cover-search  form-search-med">
                  <div
                      class="input-group mb-3 back_ground_loader row-search ui-widget"
                  >
                      <input
                          type="text"
                          class="form-control search_medicine"
                          placeholder="¿Te gustaría agregar otro producto?"
                          aria-label="¿Te gustaría agregar otro producto?"
                          aria-describedby="basic-addon2"
                          id="search_medicine"
                      />
                      <div class="input-group-append">
                          <span
                              class="input-group-text btn-med-search"
                              id="basic-addon2"
                              ><span
                                  class="fas fa-search"
                                  id="searchButton"
                              ></span
                          ></span>
                      </div>
                  </div>
              </form>
          </div>

          <div class="dra-box mt-4">
              <h3 class="mb-4">Productos Relacionados</h3>
          </div>
      </div>
      <div class="col-md-8">
        <div class="cart">
          <p class="text-justify">
              {{--  Si terminaste de adicionar medicamentos a tu carro de
              compras, por favor busca y carga la fórmula médica en
              el espacio de abajo. Tambien podras subir una
              fórmula médica, sin agregar medicamentos a tu carrito.
              Nosotros identificaremos los medicamentos y procesaremos
              tu orden. --}}
          </p>

          <div class="d-sm-none d-md-block" id ="tableBig" >
            <table class="table table-striped my-4">
              <thead>
                  <tr>
                      <th scope="col">ITEM</th>
                      <th scope="col">CANTIDAD</th>
                      <th scope="col">PRECIO POR UNIDAD</th>
                      <!-- <th scope="col">DESCUENTO POR UNIDAD</th> -->
                      <th scope="col">SUBTOTAL</th>
                  </tr>
              </thead>
              <tbody>
                <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">
                <?php $subtotal= $first_medicine = $pres_required = 0; ?>
                @if(count($current_orders)>0)
                <?php
                  $first_medicine = $current_orders[0]->medicine_id;
                  $shipping = 0;

                ?>
                @foreach($current_orders as $cart_item)
                    <?php

                          $medicine = App\Medicine::medicines($cart_item->medicine_id);
                          if($cart_item->is_pres_required == 1)
                            $pres_required = 1;
                      ?>

                    <tr>
                        <td class="txt-green col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <div class="cart-td1">
                              <!-- <input type="checkbox" class="checkbox" id="agree"> -->
                              {{--<a href="{{URL::to('medicine/view-item-info/'.$cart_item->item_code)}}"><label class="cart-item">{{ $cart_item->medicine_name }}</label></a>--}}
                              <a><label class="cart-item" onclick="get_medicine_data('{{ $cart_item->medicine_id }}')">
                                {{ $medicine['item_name'] }}</label>
                              </a>
                              <a href="{{ URL::to('medicine/remove-from-cart/'.$cart_item->id) }}" class="remove-item">
                                Eliminar
                              </a>
                            <div>
                        </td>
                        <td>
                          <input type="number" style="width:40px; border: 1px solid #ABADB3; text-align: center;" item_code="{{ $cart_item->item_code }}" value="{{$cart_item->medicine_count}}" onchange="change_count(this);">
                        </td>
                        <td class="text-right col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <p>{{ '$' . $mrp = number_format($cart_item->unit_price,0, ',', '.')}}</p>
                        </td>

                        {{-- <td class="text-right col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <p>{{ '$' . $discount = number_format($medicine['discount'],0, ',', '.')}}</p>
                        </td> --}}

                        <?php  // $total = ((int)$cart_item->unit_price * (int)$cart_item->medicine_count); ?>
                        <?php $total=$cart_item->unit_price * $cart_item->medicine_count ?>
                        <td class="text-right col-lg-2 col-md-2 col-sm-0 col-xs-0">
                          {{ '$' . number_format($total, 0, ',', '.')  }}
                        </td>

                        <?php $subtotal += $total;  ?>
                    </tr>
                    @endforeach

                    <tr>
                      <td class="text-right" style="text-align:right" colspan="3">
                        <h4 style="padding-right: 40px;">Sub-Total <span style="font-size: 12px"></span> : </h4>
                      </td>
                      <td>
                        <h4 id="subTotal" data-value={{$subtotal}} >{{ '$' . number_format($subtotal, 0, ',', '.')  }}</h4>
                        {{--   money_format("%.2n", $subtotal)--}}
                      </td>
                    </tr>

                    <tr>
                      <td colspan="3" class="col-lg-12 col-md-12 col-sm-12">
                        <div id="shipping_options" >
                          <style type="text/css">
                            fieldset {
                              overflow: hidden
                            }

                            .shipping_method {
                              float: left;
                              clear: none;
                            }

                            label {
                              float: left;
                              clear: none;
                              display: block;
                              padding: 0px 1em 0px 8px;
                            }

                            input[type=radio],
                            input.radio {
                              float: left;
                              clear: none;
                              margin: 2px 0 0 2px;
                            }
                          </style>
                          <fieldset id="shipping_method" >
                            <div class="shipping_method">
                              <label for="farmacia">
                                <input type="radio" class="radio" name="shipping" value=0 id="farmacia"> Recoger en la farmacia (Gratis)
                              </label>
                              <label for="mensajero">
                                <input type="radio" class="radio"  name="shipping" value=2000 id="mensajero"> Domicilio ($ 2.000)
                              </label>
                            </div>
                          </fieldset>
                        </div>
                      </td>
                      <td class="text-right">
                        <h5 id="shipping_value" value={{$shipping}}>{{ '$' . number_format($shipping,0, ',', '.')}}</h5>
                      </td>
                    </tr>
                    
                    <tr>
                      <td class="text-right" style="text-align:right" colspan="3">
                        <h4 style="padding-right: 40px;">Total <span style="font-size: 12px">({{ __('this is an approximate total, price may change')}})</span> : </h4>
                      </td>
                      <td nowrap>
                        <h4 class="text-right" id="totalOrder" value={{$subtotal+$shipping}}>{{ '$' . number_format($subtotal+$shipping, 0, ',', '.')   }}</h4>
                        {{-- number_format($subtotal+$shipping,2)--}}
                      </td>
                    </tr>

                <!-- Si el carrito esta vacio -->
                @else
                  <?php $pres_required = 1; ?>
                  <h4 style="color: red;" align="center">{{ __('Cart is empty')}}</h4>
                @endif
              </tbody>
              @if($pres_required != 1)
                <tfoot>
                  <tr>
                    <td colspan=4>
          
                      <div id="send_formula" class="">
                        <form method="post" action="/medicine/store-prescription/1" enctype="multipart/form-data" novalidate class="" id="noformula">
                          <input type="" name="shipping_cost" id="shippingForm" value="" hidden required />
                          <input type="" name="is_pres_required" id="is_pres_required" value="{{$pres_required}}" hidden/>
                          <input type="" name="sub_total" id="sub_total_form" value="{{$subtotal}}" hidden/>
                          <!-- Flexbox container for aligning the toasts -->
                          <!-- <button type="submit" class="box__button">Upload</button> -->
                          <button  type="submit" class="float-right mt-4 dra-button btn" data-color="#40E0BC" id="uploadBtnNF" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Procesando tu orden">
                            <img class="mail_loader" style="display: none;" src="./assets/images/loader1.gif"> {{ __('Place Order')}}
                          </button>
                          <div style="text-align: center;">

                            <div class="box__uploading" style="color: green; font-weigth:bold">
                              Enviando tu orden....&hellip; <br>
                            </div>

                            <div class="box__success" style="color: green">
                                <br> En unos segundos seras redirigido a tu perfil, una vez la verifiquemos, cambiara su estado a "verificado" y podrás realizar el pago!  
                            </div>

                            <div class="box__error" style="color: red; font-weigth:bold" id="errorMsg" style="display:none">
                              <span class="box__error__msg" id ="box__error__msg" style="color:red"></span>. <br>
                              {{-- <a href="https://css-tricks.com/examples/DragAndDropFileUploading//?" class="box__restart" role="button">Intente de nuevo!</a> --}}
                            </div>
                          </div>

                        </form>
                      </div>
                      <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
                        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                          <div class="toast-header">
                            {{-- <img src="..." class="rounded mr-2" alt="..."> --}}
                            <strong class="mr-auto">Drazamed</strong>
                            <small class="text-muted">Ahora</small>
                            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="toast-body">
                            Orden enviada! En unos segundos sera redirigido a su perfil para realizar el pago
                          </div>
                        </div>
                      </div>

                    {{-- <button class="float-right mt-4 dra-button" data-color="#40E0BC" id="uploadBtnNoFormula" >{{ __('Place Order')}}</button> --}}
                    </td>
                  </tr>
                </tfoot>
              @endif
            </table>
          </div>

          <div class="d-sm-block d-md-none">
            <table class="table table-striped my-4">
              <thead>
                  <tr>
                      <th scope="col">ITEM</th>
                      <th scope="col">CANTIDAD</th>
                      <th scope="col">PRECIO POR UNIDAD</th>
                  </tr>
              </thead>
              <tbody>
                <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">
                <?php $subtotal= $first_medicine = $pres_required = 0; ?>
                @if(count($current_orders)>0)
                <?php
                  $first_medicine = $current_orders[0]->medicine_id;
                  $shipping = 0;

                ?>
                @foreach($current_orders as $cart_item)
                    <?php

                          $medicine = App\Medicine::medicines($cart_item->medicine_id);
                          if($cart_item->is_pres_required == 1)
                            $pres_required = 1;
                      ?>

                    <tr>
                        <td class="txt-green col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <div class="cart-td1">
                              <!-- <input type="checkbox" class="checkbox" id="agree"> -->
                              {{--<a href="{{URL::to('medicine/view-item-info/'.$cart_item->item_code)}}"><label class="cart-item">{{ $cart_item->medicine_name }}</label></a>--}}
                              <a><label class="cart-item" onclick="get_medicine_data('{{ $cart_item->medicine_id }}')">
                                {{ $medicine['item_name'] }}</label>
                              </a>
                              <a href="{{ URL::to('medicine/remove-from-cart/'.$cart_item->id) }}" class="remove-item">
                                Eliminar
                              </a>
                            <div>
                        </td>
                        <td>
                          <input type="number" style="width:40px; border: 1px solid #ABADB3; text-align: center;" item_code="{{ $cart_item->item_code }}" value="{{$cart_item->medicine_count}}" onchange="change_count(this);">
                        </td>
                        <td class="text-right col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <p>{{ '$' . $mrp = number_format($cart_item->unit_price,0, ',', '.')}}</p>
                        </td>


                        <?php  // $total = ((int)$cart_item->unit_price * (int)$cart_item->medicine_count); ?>
                        <?php $total=$cart_item->unit_price * $cart_item->medicine_count ?>

                        <?php $subtotal += $total;  ?>
                    </tr>
                    @endforeach

                    <tr>
                      <td class="text-right" style="text-align:right" colspan="2">
                        <h4 style="padding-right: 10px;">Sub-Total <span style="font-size: 12px"></span> : </h4>
                      </td>
                      <td>
                        <h4 id="subTotal" data-value={{$subtotal}} >{{ '$' . number_format($subtotal, 0, ',', '.')  }}</h4>
                        {{--   money_format("%.2n", $subtotal)--}}
                      </td>
                    </tr>

                    <tr>
                      <td colspan="2" class="col-lg-12 col-md-12 col-sm-12">
                        <div id="shipping_options" >
                          <style type="text/css">
                            fieldset {
                              overflow: hidden
                            }

                            .shipping_method {
                              float: left;
                              clear: none;
                            }

                            label {
                              float: left;
                              clear: none;
                              display: block;
                              padding: 0px 1em 0px 8px;
                            }

                            input[type=radio],
                            input.radio {
                              float: left;
                              clear: none;
                              margin: 2px 0 0 2px;
                            }
                          </style>
                          <fieldset id="shipping_method" >
                            <div class="shipping_method">
                              <label for="farmacia">
                                <input type="radio" class="radio" name="shipping" value=0 id="farmacia"> Recoger en la farmacia (Gratis)
                              </label>
                              <label for="mensajero">
                                <input type="radio" class="radio"  name="shipping" value=2000 id="mensajero"> Domicilio ($ 2.000)
                              </label>
                            </div>
                          </fieldset>
                        </div>
                      </td>
                      <td class="text-right">
                        <h5 id="shipping_value" value={{$shipping}}>{{ '$' . number_format($shipping,0, ',', '.')}}</h5>
                      </td>
                    </tr>
                    
                    <tr>
                      <td class="text-right" style="text-align:right" colspan="2">
                        <h4 style="padding-right: 40px;">Total <span style="font-size: 12px">({{ __('this is an approximate total, price may change')}})</span> : </h4>
                      </td>
                      <td nowrap>
                        <h4 class="text-right" id="totalOrder" value={{$subtotal+$shipping}}>{{ '$' . number_format($subtotal+$shipping, 0, ',', '.')   }}</h4>
                        {{-- number_format($subtotal+$shipping,2)--}}
                      </td>
                    </tr>

                <!-- Si el carrito esta vacio -->
                @else
                  <?php $pres_required = 1; ?>
                  <h4 style="color: red;" align="center">{{ __('Cart is empty')}}</h4>
                @endif
              </tbody>
              @if($pres_required != 1)
                <tfoot>
                  <tr>
                    <td colspan=4>
          
                      <div id="send_formula" class="">
                        <form method="post" action="/medicine/store-prescription/1" enctype="multipart/form-data" novalidate class="" id="noformula">
                          <input type="" name="shipping_cost" id="shippingForm" value="" hidden required />
                          <input type="" name="is_pres_required" id="is_pres_required" value="{{$pres_required}}" hidden/>
                          <input type="" name="sub_total" id="sub_total_form" value="{{$subtotal}}" hidden/>
                          <!-- Flexbox container for aligning the toasts -->
                          <!-- <button type="submit" class="box__button">Upload</button> -->
                          <button  type="submit" class="float-right mt-4 dra-button btn" data-color="#40E0BC" id="uploadBtnNF" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Procesando tu orden">
                            <img class="mail_loader" style="display: none;" src="./assets/images/loader1.gif"> {{ __('Place Order')}}
                          </button>
                          <div style="text-align: center;">

                            <div class="box__uploading" style="color: green; font-weigth:bold">
                              Enviando tu orden....&hellip; <br>
                            </div>

                            <div class="box__success" style="color: green">
                                <br> En unos segundos seras redirigido a tu perfil, una vez la verifiquemos, cambiara su estado a "verificado" y podrás realizar el pago!  
                            </div>

                            <div class="box__error" style="color: red; font-weigth:bold" id="errorMsg" style="display:none">
                              <span class="box__error__msg" id ="box__error__msg" style="color:red"></span>. <br>
                              {{-- <a href="https://css-tricks.com/examples/DragAndDropFileUploading//?" class="box__restart" role="button">Intente de nuevo!</a> --}}
                            </div>
                          </div>

                        </form>
                      </div>
                      <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
                        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                          <div class="toast-header">
                            {{-- <img src="..." class="rounded mr-2" alt="..."> --}}
                            <strong class="mr-auto">Drazamed</strong>
                            <small class="text-muted">Ahora</small>
                            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="toast-body">
                            Orden enviada! En unos segundos sera redirigido a su perfil para realizar el pago
                          </div>
                        </div>
                      </div>

                    {{-- <button class="float-right mt-4 dra-button" data-color="#40E0BC" id="uploadBtnNoFormula" >{{ __('Place Order')}}</button> --}}
                    </td>
                  </tr>
                </tfoot>
              @endif
            </table>
          </div>

          <!-- Envio de formulas medicas mediante drag & drop -->
          <div class="p3">
            @if($pres_required == 1)
              @include('design.dropbox')
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
  $(document).on({
      ajaxStart: function() {
                  $('.cart_loader').css('display', 'inline' );
                },
      ajaxStop: function() {
                  $('.cart_loader').css('display', 'none' );
                }
  });

  var formulario;

  $("#noformula").on('submit', function(event){
    event.preventDefault();

    $('.box__uploading').fadeIn("slow");

    $('#uploadBtnNF').prop('disabled', true);

    var form = $(this);
    console.log("Method");
    var method = form.attr( 'method' );
    console.log(method);
    console.log("Action");
    var url = form.attr('action');
    console.log(url);

    $().toast('show');

    formulario = form;

    $.ajax({
          url:url,
          type: method,
          data: form.serialize(), // coje los valores del formulario y los transmite
          cache: false,
          statusCode:{
              400:function(data){
              console.log(data);
                  $('.alert-danger').html(data.responseJSON.msg).removeClass('hide');
              },
              403:function(data){
                  $('.alert-danger').html(data.responseJSON.msg).removeClass('hide');
              }
          },
          success:function(responseText){

            console.log(responseText);
            var data = responseText;

            if( data.status == "FAILURE" ) {
              $("#errorMsg").show();
              $("#box__error__msg").html(data.msg);
              setTimeout(function(){location.reload()}, 2000)
            }

            if (data.status == "SUCCESS") {
              $('.box__success').fadeIn("slow");
              setTimeout(function(){window.location="/account-page/#por_pagar";}, 2000)
            }

          },
          error: function (error) {
              alert('error; ' + eval(error));
          }
    })




  })

  // Cambio en el metodo de envio
  $('input:radio[name="shipping"]').change(
    function(){
        // console.log(element = $(this))
        if ($(this).is(':checked')) {
            shipping = $(this).val();
            subTotal = $('#subTotal').data('value');
            console.log('subTotal:'+ subTotal);
            console.log('Shipping:'+ shipping);
            $('#shipping_value').val(convertToMoney(shipping));
            $('#shippingForm').val(shipping);
            $('#shipping_value').html('$ ' + $('#shipping_value').val());
            total = Number(shipping)+Number(subTotal);
            $('#totalOrder').val(convertToMoney(total));
            $('#totalOrder').html('$ ' + $('#totalOrder').val());
        }
    }
  );

  function convertToMoney(text) {
      return '$ ' + text.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
  }

  function goto_detail_page(){
    $(".search_medicine").val("");
    var serched_medicine=$(".search_medicine").val();
    window.location="{{URL::to('medicine-detail/')}}/"+current_item_code;

  }

  function change_count(obj){
    var item_code=$(obj).attr('item_code');
    var new_qty=parseInt($(obj).val());
    var _token = $('#_token').val();
    if(new_qty <= 0 || isNaN(new_qty)){
      $('.quantity-alert').addClass('show').removeClass('hide');
      setTimeout(function(){
        $('.quantity-alert').addClass('hide').removeClass('show');
      },2000);
      return false;
    }

    $.ajax({

        url:'{{ URL::to('medicine/update-cart/' )}}',
        type:'POST',
        data:'item_code='+item_code+'&new_qty='+new_qty+'&_token='+_token,
        success: function(alerts){
            if(alerts==1)
            {
                location.reload();
            }
            else
            {
            alert("{{ __('Could\'t complete your request')}}");
            }
        }
    });
  }

  function get_medicine_data(id){
    $.ajax({
    url:'{{ URL::to('medicine/medicine-data/' )}}',
    type:'GET',
    data:'id='+id,
    datatype: 'JSON',
    success: function(data){
    var data = data.data;
    var med_comp="";
        $('#med_name').html(data.item_name);
        comp=data.composition.split(',');
        for(i=0;i<comp.length;i++)
        {
            med_comp+="<h5>"+comp[i]+"</h5>";
        }
        $('#med_comp').html(med_comp);
        $('#mfg').html(data.manufacturer);
        $('#group').html(data.group);

    }
    });
  }

  /**
   * Busqueda de Medicamentos por nombre
   * @param cat= Categoria lab= Laboratorio term= Nombre Medicamento limit= #resultados max
   */
  $("#search_medicine")
    .autocomplete({
        search: function(event, ui) {
            $(".med_search_loader").css("display", "block");
        },
        open: function(event, ui) {
            $(".med_search_loader").css("display", "none");
        },
        source: "/medicine/load-medicine-web/1",
        minLength: 2,
        delay: 0,
        max: 10,

        response: function(event, ui) {
            $(".med_search_loader").css("display", "none");
        },

        select: function(event, ui) {
            console.log("itemCode=" + ui.item.item_code);
            item_code = ui.item.item_code;
            current_item_code = item_code;
            // goto_detail_page();
            show_detail_modal(ui.item);
        }
    })
    .autocomplete("instance")._renderItem = function(ul, item) {
            // console.log(item);
            availability = (item.quantity >= 50) ? "Disponible" : "No Disponible";
            color = (item.quantity >= 50) ? "green" : "Red";


            card = "<div class='card'>" +
                        "<div class='row no-gutters'>" +
                            "<div class='col-auto'>" +
                                "<img width='100px' src='" + item.imgUrl + "' class='img-fluid' >" +
                            "</div>" +
                            "<div class='col'>" +
                                "<div class='card-block px-2'>" +
                                    "<h5 class='card-title'>" + item.value + "</h5>" +
                                    "<p class='card-text'>" + item.composition + "</p>" +
                                    "<p class='card-text' style='color:" + color + "'>" + availability + "</p>" +
                                "</div>" +
                            "</div>" +
                        "</div>" +
                    "</div>";
            return $("<li>")
                .append(card)
                .appendTo(ul);
            };


</script>

@endsection



