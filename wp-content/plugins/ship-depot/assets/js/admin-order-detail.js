function GetShippingFee(paramAjax, isAddNew) {
    jQuery('#loading_text').show();
    let selectedCour = "";
    if (!isAddNew) {
        selectedCour = jQuery("#selectedCourier").val();
    }

    jQuery.ajax({
        url: sd_admin_address_params.ajax.url,
        type: 'post',
        data: paramAjax,
        success: function (response) {
            console.log('GetShippingFee success');
            jQuery('#loading_text').hide();
            jQuery('#shipping_fee_content').empty();
            if (!response.success || !validateData(JSON.parse(paramAjax.dataInput).orderID)) {
                return;
            }

            let listFees = JSON.parse(response.data);
            jQuery.each(listFees, function (index, courier) {
                //console.log(courier);
                let $div = jQuery("<div>", {
                    id: courier.CourierID,
                    class: 'courier-fee'
                });
                let clss = '';
                if (selectedCour != '' && selectedCour != courier.CourierID) {
                    clss = ' disable-element';
                    $div.addClass('disable-element');
                }
                let inHTML = $div.html();
                inHTML += `<img src="${courier.LogoURL}" alt="${courier.CourierName}" data-placement="bottom" title="${courier.CourierName}">`;
                //Add json courier detail
                let courClone = {};
                for (var key in courier) {
                    courClone[key] = courier[key];
                    if (key == 'ListServices') {
                        courClone[key] = [];
                    } else if (key == 'LogoURL') {
                        courClone[key] = '';
                    }
                }

                let jsonCour = ParseObjToHTMLJson(courClone);
                inHTML += `<input type="hidden" id="courier_info" name="shipdepot[${courier.CourierID}][courier_info]" value="${jsonCour}">`;
                //
                inHTML += `<div class="service-fee">`;
                jQuery.each(courier.ListServices, function (index, serv) {
                    const re = /"/gi;
                    let json = ParseObjToHTMLJson(serv);
                    inHTML += `<div class="service-fee-info">
                                            <input type="hidden" id="${serv.ServiceCode}" name="shipdepot[radio_shipping_fee][${serv.ServiceCode}]" value="${json}"/>
                                            <input type="radio" id="rd_${serv.ServiceCode}" name="shipdepot[radio_shipping_fee]" class="radio_shipping_fee${clss}" value="${serv.ServiceCode}" /> `;
                    inHTML += `<div class="service-fee-description"><label for="rd_${serv.ServiceCode}" class="service-name">${serv.ServiceName}</label>`;
                    let mainSFee = serv.ShopMarkupShippingFee.IsActive ? serv.ShopMarkupShippingFee : serv.ShipDepotMarkupShippingFee;
                    let totalSFee = mainSFee.ShippingFeeTotal;
                    if (serv.NoMarkupShippingFee) {
                        totalSFee += serv.NoMarkupShippingFee.NoMarkupShippingFeeTotal;
                    }
                    inHTML += `
                        <div>
                            <b>${formatVNCurrency(totalSFee)}</b>
                        </div>
                        <p class="description">
                        Phí giao hàng: ${formatVNCurrency(mainSFee.ShippingFeeNet + mainSFee.OtherFees)} + Phí thu hộ: ${formatVNCurrency(mainSFee.CODFee)} + Phí bảo hiểm: ${formatVNCurrency(mainSFee.InsuranceFee)} + Phí giao thất bại: ${formatVNCurrency(serv.NoMarkupShippingFee.CODFailedFee)}
                        </p>`;
                    if (serv.ShopMarkupShippingFee.IsActive) {
                        inHTML += `
                        <p class="description">
                        Tổng phí chưa qua thay đổi: ${formatVNCurrency(serv.ShipDepotMarkupShippingFee.ShippingFeeTotal + serv.NoMarkupShippingFee.NoMarkupShippingFeeTotal)} = Phí giao hàng: ${formatVNCurrency(serv.ShipDepotMarkupShippingFee.ShippingFeeNet + serv.ShipDepotMarkupShippingFee.OtherFees)} + Phí thu hộ: ${formatVNCurrency(serv.ShipDepotMarkupShippingFee.CODFee)} + Phí bảo hiểm: ${formatVNCurrency(serv.ShipDepotMarkupShippingFee.InsuranceFee)} + Phí giao thất bại: ${formatVNCurrency(serv.NoMarkupShippingFee.CODFailedFee)}
                        </p>`;
                    }

                    if (serv.TimeExpected != '') {
                        inHTML += `<p class="description">T.gian nhận hàng ước tính: ${serv.TimeExpected}</p>`;
                    }

                    if (courier.CODFailed != null && courier.CODFailed.IsUsed) {
                        inHTML += `<p class="cod-failed-description">Nếu khách hàng không nhận hàng, họ cần thanh toán phí ship là  ${formatVNCurrency(courier.CODFailed.CODFailedAmount)}</p>`;
                    }

                    if (courier.CourierID == 'GHTK') {
                        inHTML += `<p class="description">*Giao hàng tiết kiệm tự động tính phí bảo hiểm với đơn hàng có tổng giá trị sản phẩm lớn hơn 1 triệu đồng.</p>`;
                    }
                    inHTML += `</div></div>`;
                });
                inHTML += `</div>`;
                $div.html(inHTML);
                jQuery('#shipping_fee_content').append($div);
                jQuery('#sd_note').show();
            });

            let selectedServiceID = '';
            let jsonSelectedShipping = jQuery('#selectedShipping').val();
            if (jsonSelectedShipping != '') {
                let jsonRpl = jsonSelectedShipping.replace(new RegExp(`'`, 'g'), `\"`);
                let serv = JSON.parse(jsonRpl);
                selectedServiceID = serv.ServiceCode;
            }

            if (selectedServiceID != '') {
                jQuery('#shipping_fee_content').find('input[type=radio][class=radio_shipping_fee]').each(function () {
                    if (jQuery(this).val() == selectedServiceID) {
                        console.log('GetShippingFee success => select service: ', selectedServiceID);
                        jQuery(this).prop('checked', true).trigger('change');
                    }
                });
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            jQuery('#loading_text').hide();
            jQuery('#shipping_fee_content').empty();
            //Làm gì đó khi có lỗi xảy ra
            console.log('[GetShippingFee] error occured: ' + textStatus, errorThrown);
        }

    });
}

function GetShippingFeeJS(paramAjax, isAddNew) {
    jQuery('#loading_text').show();
    let selectedCour = "";
    if (!isAddNew) {
        selectedCour = jQuery("#selectedCourier").val();
    }

    jQuery.ajax({
        url: sd_admin_address_params.ajax.url,
        type: 'post',
        data: paramAjax,
        success: function (response) {

            jQuery('#loading_text').hide();
            jQuery('#shipping_fee_content').empty();
            if (!response.success || !validateData(JSON.parse(paramAjax.dataInput).orderID)) {
                return;
            }

            let listCouriers = JSON.parse(response.data);
            let listCouriersHTML = listCouriers.map(function (courier, index) {
                const newDiv = document.createElement("div");
                newDiv.id = courier.CourierID;
                newDiv.classList.add('courier-fee');

                let clss = '';
                if (selectedCour != '' && selectedCour != courier.CourierID) {
                    clss = ' disable-element';
                    newDiv.classList.add('disable-element');
                }

                let inHTML = `<img src="${courier.LogoURL}" alt="${courier.CourierName}" data-placement="bottom" title="${courier.CourierName}">`;
                //Add json courier detail
                const re = /"/gi;
                let courClone = {};
                for (var key in courier) {
                    courClone[key] = courier[key];
                    if (key == 'ListServices') {
                        courClone[key] = [];
                    } else if (key == 'LogoURL') {
                        courClone[key] = '';
                    }
                }

                let jsonCour = ParseObjToHTMLJson(courClone);
                inHTML += `<input type="hidden" id="courier_info" name="shipdepot[${courier.CourierID}][courier_info]" value="${jsonCour}">`;
                //
                inHTML += `<div class="service-fee">`;
                let listServicesHTML = courier.ListServices.map(function (serv, index) {
                    let json = ParseObjToHTMLJson(serv);
                    let servHTML = `<div class="service-fee-info clear-fix">
                                   <input type="hidden" id="${serv.ServiceCode}" name="shipdepot[radio_shipping_fee][${serv.ServiceCode}]" value="${json}"/>
                                   <input type="radio" id="rd_${serv.ServiceCode}" name="shipdepot[radio_shipping_fee]" class="radio_shipping_fee${clss}" value="${serv.ServiceCode}" /> `;
                    servHTML += `<div class="service-fee-description">
                                   <label for="rd_${serv.ServiceCode}" class="service-name">${serv.ServiceName}</label>`;
                    let mainSFee = serv.ShopMarkupShippingFee.IsActive ? serv.ShopMarkupShippingFee : serv.ShipDepotMarkupShippingFee;
                    let totalSFee = mainSFee.ShippingFeeTotal;
                    if (serv.NoMarkupShippingFee) {
                        totalSFee += serv.NoMarkupShippingFee.NoMarkupShippingFeeTotal;
                    }
                    inHTML += `
                                       <div>
                                            <b>${formatVNCurrency(totalSFee)}</b>
                                       </div>
                                       <p class="description">
                                       Phí giao hàng: ${formatVNCurrency(mainSFee.ShippingFeeNet + mainSFee.OtherFees)} + Phí thu hộ: ${formatVNCurrency(mainSFee.CODFee)} + Phí bảo hiểm: ${formatVNCurrency(mainSFee.InsuranceFee)} + Phí giao thất bại: ${formatVNCurrency(serv.NoMarkupShippingFee.CODFailedFee)}
                                       </p>`;
                    if (serv.ShopMarkupShippingFee.IsActive) {
                        inHTML += `
                                       <p class="description">
                                       Tổng phí chưa qua thay đổi: ${formatVNCurrency(serv.ShipDepotMarkupShippingFee.ShippingFeeTotal + serv.NoMarkupShippingFee.NoMarkupShippingFeeTotal)} = Phí giao hàng: ${formatVNCurrency(serv.ShipDepotMarkupShippingFee.ShippingFeeNet + serv.ShipDepotMarkupShippingFee.OtherFees)} + Phí thu hộ: ${formatVNCurrency(serv.ShipDepotMarkupShippingFee.CODFee)} + Phí bảo hiểm: ${formatVNCurrency(serv.ShipDepotMarkupShippingFee.InsuranceFee)} + Phí giao thất bại: ${formatVNCurrency(serv.NoMarkupShippingFee.CODFailedFee)}
                                       </p>`;
                    }

                    if (serv.TimeExpected != '') {
                        servHTML += `<p class="description"> T.gian nhận hàng ước tính: ${serv.TimeExpected}</p > `;
                    }

                    if (courier.CODFailed != null && courier.CODFailed.IsUsed) {
                        servHTML += `<p class="cod-failed-description"> Nếu khách hàng không nhận hàng, họ cần thanh toán phí ship là  ${formatVNCurrency(serv.CODFailedAmount)}</p>`;
                    }

                    if (courier.CourierID == 'GHTK') {
                        servHTML += `<p class="description">* Giao hàng tiết kiệm tự động tính phí bảo hiểm với đơn hàng có tổng giá trị sản phẩm lớn hơn 1 triệu đồng.</p>`;
                    }
                    servHTML += `</div >
                    </div >`;
                    return servHTML;
                });
                inHTML += listServicesHTML.join('');
                inHTML += `</div >`;
                newDiv.innerHTML = inHTML;
                return newDiv.outerHTML;
            });
            jQuery('#sd_note').show();
            jQuery('#shipping_fee_content').html(listCouriersHTML.join(''));
            let selectedServiceID = '';
            let jsonSelectedShipping = jQuery('#selectedShipping').val();
            if (jsonSelectedShipping != '') {
                let jsonRpl = jsonSelectedShipping.replace(new RegExp(`'`, 'g'), `\"`);
                let serv = JSON.parse(jsonRpl);
                selectedServiceID = serv.ServiceCode;
            }

            if (selectedServiceID != '') {
                jQuery('#shipping_fee_content').find('input[type=radio][class=radio_shipping_fee]').each(function () {
                    if (jQuery(this).val() == selectedServiceID) {
                        jQuery(this).prop('checked', true).trigger('change');
                    }
                });
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            jQuery('#loading_text').hide();
            jQuery('#shipping_fee_content').empty();
            //Làm gì đó khi có lỗi xảy ra
            console.log('[GetShippingFee] error occured: ' + textStatus, errorThrown);
        }

    });
}

function updateShippingFee(orderID, isclearShipping, json = '', fromNotCreateShip, forceReload = false) {
    //console.log(`[updateShippingFee] forceReload: ${forceReload}`);
    blockListItemBox();
    if (fromNotCreateShip) {
        forceReload = true;
        fromNotCreateShip = false;
    }

    //Compare old and new shipping fee
    let oldShipFee = -1;
    let selectedService = jQuery('#selectedShipping').val();
    if (selectedService != '') {
        let jsonRpl = selectedService.replace(new RegExp(`'`, 'g'), `\"`);
        let serv = JSON.parse(jsonRpl);
        oldShipFee = serv.ShopMarkupShippingFee.IsActive ? serv.ShopMarkupShippingFee.ShippingFeeTotal : serv.ShipDepotMarkupShippingFee.ShippingFeeTotal;
    }
    let courierID = "";
    let curShipFee = -1;
    if (json != '') {
        let jsonRpl = json.replace(new RegExp(`'`, 'g'), `\"`);
        let serv = JSON.parse(jsonRpl);
        curShipFee = serv.ShopMarkupShippingFee.IsActive ? serv.ShopMarkupShippingFee.ShippingFeeTotal : serv.ShipDepotMarkupShippingFee.ShippingFeeTotal;
        courierID = serv.CourierID;
    }

    jQuery('#selectedCourier').val(courierID);
    jQuery('#selectedShipping').val(json);

    if (forceReload || oldShipFee != curShipFee) {
        jQuery.ajax({
            url: sd_order_detail_params.ajax.url, //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
            type: "post",
            dataType: 'json',
            context: this,
            data: {
                action: "calculateTotal", //Tên action
                shippingObj: json,
                orderID: orderID,
                clearShipping: isclearShipping,
                courierID: courierID
            },
            success: function (response) {
                if (response.data) {
                    console.log(`[updateShippingFee] recalculateTotal`);
                    recalculateTotal();
                } else {
                    unblockListItemBox();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(sd_order_detail_params.error_messages.error_total);
                unblockListItemBox();
                console.log('[CalculateTotal] error occured: ' + textStatus, errorThrown);
            }
        });
    } else {
        unblockListItemBox();
    }
}

function clearShippingFee(orderID, removeSelectedShipping) {
    jQuery('#shipping_fee_content').empty();
    jQuery('#sd_note').hide();
    if (removeSelectedShipping) {
        jQuery('#selectedShipping').val('');
        updateShippingFee(orderID, true, '', false, true);
    } else {
        updateShippingFee(orderID, true, jQuery('#selectedShipping').val(), false, true);
    }

}

function checkPackage(highlightError = true) {
    let hasError = false;
    jQuery('#package_size_container').find('input[data-type=currency]').each(function () {
        if (jQuery(this).val() == '') {
            if (!(jQuery(this).hasClass('error-class'))) {
                if (highlightError) {
                    jQuery(this).addClass('error-class');
                }
            }
            hasError = true;
        } else {
            if (jQuery(this).hasClass('error-class')) {
                jQuery(this).removeClass('error-class');
            }
        }
    });
    return !hasError;
}

function checkReceiver(highlightError = true) {
    let hasError = false;
    //
    jQuery('.load_customer_shipping').parents('.order_data_column').children('h3').css('color', '');
    jQuery('.load_customer_shipping').parents('.order_data_column').find('.none_set').css('color', '');
    //
    jQuery('#receiver_info').find('input[type=text]').each(function () {
        if (jQuery(this).hasClass('error-class')) {
            jQuery(this).removeClass('error-class');
        }
    });

    if (jQuery('#rd_receiver_type_other').is(':checked')) {
        jQuery('#receiver_info').find('input[type=text]').each(function () {
            if (jQuery(this).val() == '') {
                if (!(jQuery(this).hasClass('error-class'))) {
                    if (highlightError) {
                        jQuery(this).addClass('error-class');
                    }
                }
                hasError = true;
            }
        });
    } else {
        if (jQuery('#_shipping_last_name').val() == '' || jQuery('#_shipping_first_name').val() == '' || jQuery('#_shipping_country').val() == '' || jQuery('#_shipping_phone').val() == '' || jQuery('#_shipping_address_1').val() == '' || jQuery('#_shipping_ward').val() == '' || jQuery('#_shipping_district').val() == '' || jQuery('#_shipping_city').val() == '') {
            if (highlightError) {
                jQuery('.load_customer_shipping').parents('.order_data_column').children('h3').css('color', 'red');
                jQuery('.load_customer_shipping').parents('.order_data_column').find('.none_set').css('color', 'red');
            }
            hasError = true;
        }
    }
    return !hasError;
}

function validateData(orderID) {
    jQuery('#error_message_content').empty();
    let pkCheck = checkPackage();
    let rcCheck = checkReceiver();
    if (pkCheck && rcCheck) {
        return true;
    } else {
        clearShippingFee(orderID, false);
        let msgHtml = sd_order_detail_params.error_messages.error_required;
        let pkMsg = `<b>${sd_order_detail_params.error_messages.package}</b>`;
        let rcvMsg = `<b>${sd_order_detail_params.error_messages.receiver}</b>`;
        if (!pkCheck && !rcCheck) {
            msgHtml = msgHtml.replace('[param]', pkMsg + ` ${sd_order_detail_params.error_messages.and} ` + rcvMsg);
        } else if (!pkCheck) {
            msgHtml = msgHtml.replace('[param]', pkMsg);
        } else if (!rcCheck) {
            msgHtml = msgHtml.replace('[param]', rcvMsg);
        }
        jQuery('#error_message_content').html(msgHtml);
        return false;
    }
}

function CalculateShippingFee(orderID, isAddNew) {
    //clearShippingFee(orderID);
    jQuery('#shipping_fee_content').empty();
    jQuery('#sd_note').hide();

    let packageSizes = [];
    jQuery('.shipdepot_package').each(function () {
        let id = jQuery(this).val();
        let length = jQuery('#' + id + '_package_length').val().replace(/\./g, "");
        let width = jQuery('#' + id + '_package_width').val().replace(/\./g, "");
        let height = jQuery('#' + id + '_package_height').val().replace(/\./g, "");
        let weight = jQuery('#' + id + '_package_weight').val().replace(/\./g, "");
        let package = {
            Length: length,
            Width: width,
            Height: height,
            Weight: weight
        }
        packageSizes.push(package);
    });

    let receiver = {
        FirstName: '',
        LastName: '',
        Province: '',
        District: '',
        Ward: '',
        Address: '',
        Phone: ''
    }

    let receiverType = jQuery('input[class=rd_receiver_type]:checked').val();
    if (receiverType == 'current') {
        receiver = {
            FirstName: jQuery("#_shipping_first_name").val(),
            LastName: jQuery("#_shipping_last_name").val(),
            Province: jQuery("#_shipping_city").val(),
            District: jQuery("#_shipping_district").val(),
            Ward: jQuery("#_shipping_ward").val(),
            Address: jQuery("#_shipping_address_1").val(),
            Phone: jQuery("#_shipping_phone").val()
        }
    } else {
        receiver = {
            FirstName: jQuery("#receiver_first_name").val(),
            LastName: jQuery("#receiver_last_name").val(),
            Province: jQuery("#sl_receiver_province").val(),
            District: jQuery("#sl_receiver_district").val(),
            Ward: jQuery("#sl_receiver_ward").val(),
            Address: jQuery("#receiver_address").val(),
            Phone: jQuery("#receiver_phone").val()
        }
    }

    let insurance = {
        IsActive: jQuery("#cb_ins_fee").is(':checked'),
        Value: jQuery("#cb_ins_fee").is(':checked') ? jQuery("#tb_ins_fee").val().replace(/\./g, "") : 0
    }

    let cod = {
        IsActive: jQuery("#cb_cod").is(':checked'),
        Value: jQuery("#cb_cod").is(':checked') ? jQuery("#tb_cod_amount").val().replace(/\./g, "") : 0
    }

    let dataInput = {
        list_package_sizes: packageSizes,
        sender_storage: jQuery('#sl_storage').val(),
        sender_info:  jQuery('#sender_info').val(),
        receiver: receiver,
        cod: cod,
        insurance: insurance,
        orderID: orderID
    }

    let paramAjax = {
        action: 'calculate_shipping',
        dataInput: JSON.stringify(dataInput)
    }
    GetShippingFee(paramAjax, isAddNew);
}
//Handle calculate fee
function checkAndCalFee() {
    let orderID = jQuery('#order_id').val();
    let isAddNew = jQuery('#is_add_new').val() == "true" ? true : false;
    if (validateData(orderID)) {
        CalculateShippingFee(orderID, isAddNew);
    }
}

function saveOrder() {
    block(jQuery('#sd_meta_boxes'));
    jQuery('#post').submit();
}

function copyTrackingNumber(idCopy) {
    let copyText = document.getElementById(idCopy).innerText;
    copyTextToClipboard(copyText);
    // Show msg copied 
    let lb = document.getElementById('lb_copied');
    lb.innerText = lb.innerText.replace('xxx', copyText);
    lb.style.display = "inline-block";

    // Hide msg copied after 2s
    let delayInMilliseconds = 2000;
    setTimeout(function () {
        lb.style.display = "none";
        lb.innerText = lb.innerText.replace(copyText, 'xxx');
    }, delayInMilliseconds);
}

//Function recalculate get from woocommerce\assets\js\admin\meta-boxes-order.js
function recalculateTotal() {
    blockListItemBox();
    let data = jQuery.extend({}, get_taxable_address(), {
        action: 'woocommerce_calc_line_taxes',
        order_id: woocommerce_admin_meta_boxes.post_id,
        items: jQuery('table.woocommerce_order_items :input[name], .wc-order-totals-items :input[name]').serialize(),
        security: woocommerce_admin_meta_boxes.calc_totals_nonce
    });

    jQuery(document.body).trigger('order-totals-recalculate-before', data);

    jQuery.ajax({
        url: woocommerce_admin_meta_boxes.ajax_url,
        data: data,
        type: 'POST',
        success: function (response) {
            jQuery('#woocommerce-order-items').find('.inside').empty();
            jQuery('#woocommerce-order-items').find('.inside').append(response);
            reloaded_items();
            unblockListItemBox();

            jQuery(document.body).trigger('order-totals-recalculate-success', response);
        },
        complete: function (response) {
            jQuery(document.body).trigger('order-totals-recalculate-complete', response);

            window.wcTracks.recordEvent('order_edit_recalc_totals', {
                order_id: data.post_id,
                ok_cancel: 'OK',
                status: jQuery('#order_status').val()
            });
        }
    });

    return false;
}

function get_taxable_address() {
    let country = '';
    let state = '';
    let postcode = '';
    let city = '';

    if ('shipping' === woocommerce_admin_meta_boxes.tax_based_on) {
        country = jQuery('#_shipping_country').val();
        state = jQuery('#_shipping_state').val();
        postcode = jQuery('#_shipping_postcode').val();
        city = jQuery('#_shipping_city').val();
    }

    if ('billing' === woocommerce_admin_meta_boxes.tax_based_on || !country) {
        country = jQuery('#_billing_country').val();
        state = jQuery('#_billing_state').val();
        postcode = jQuery('#_billing_postcode').val();
        city = jQuery('#_billing_city').val();
    }

    return {
        country: country,
        state: state,
        postcode: postcode,
        city: city
    };
}

function reloaded_items() {
    init_tiptip();
    stupidtable_init();
}

function init_tiptip() {
    jQuery('#tiptip_holder').removeAttr('style');
    jQuery('#tiptip_arrow').removeAttr('style');
    jQuery('.tips').tipTip({
        'attribute': 'data-tip',
        'fadeIn': 50,
        'fadeOut': 50,
        'delay': 200,
        'keepAlive': true
    });
}

function stupidtable_init() {
    jQuery('.woocommerce_order_items').stupidtable();
    jQuery('.woocommerce_order_items').on('aftertablesort', this.add_arrows);
}

function blockListItemBox() {
    block(jQuery('#woocommerce-order-items'));
    block(jQuery('#shipping_fee_area'));
}

function unblockListItemBox() {
    unblock(jQuery('#woocommerce-order-items'));
    unblock(jQuery('#shipping_fee_area'));
}

jQuery(document).ready(function ($) {
    if ($('#woocommerce-order-items').length > 0) {
        $('#woocommerce-order-items').on('click', '.add-line-item', function () {
            if ($('.add-order-shipping').length > 0) {
                $('.add-order-shipping').hide();
            }
        });

        $('#woocommerce-order-items').on('change', '#tb_cod_amount', function () {
            $('#cod_amount').val($(this).val().replace(/\./g, ""));
            $('#user_modify_cod_amount').val('yes');
        });

        $('#woocommerce-order-items').on('blur', '#tb_cod_amount', function () {
            formatCurrency($(this));
            checkAndCalFee();
        });

        $('#woocommerce-order-items').on('keyup', '#tb_cod_amount', function () {
            formatCurrency($(this));
        });

    }
    let fromNotCreateShip = false;
    if ($('#cb_not_create_shipping').length > 0) {
        $("#cb_not_create_shipping").change(function () {
            let orderID = $('#order_id').val();
            if (this.checked) {
                $('#shipping_info').hide();
                $('#error_message_content').html('');
                jQuery('.load_customer_shipping').parents('.order_data_column').children('h3').css('color', '');
                jQuery('.load_customer_shipping').parents('.order_data_column').find('.none_set').css('color', '');
                updateShippingFee(orderID, true, $('#selectedShipping').val(), fromNotCreateShip, true);
            } else {
                $('#shipping_info').show();
                fromNotCreateShip = true;
                checkAndCalFee();
                //updateShippingFee(orderID, true,$('#selectedShipping').val(), fromNotCreateShip, true);
            }
        });
    }

    if ($('#btn_add_package_size').length > 0) {
        $("#btn_add_package_size").click(function () {
            let ticks = getTimeTicks();
            let id = 'pk_' + ticks;
            let $div = $("<div>", {
                "class": "package_size_row"
            });
            let inHtml = $div.html();
            inHtml += `<img src="${sd_order_detail_params.sd_dir_url}assets/images/ic_close_12px.png" class="btn_delete_package_size"/>
                <div class="container-fluid col-padding-0">
                    <div class="row" >
                        <input type="hidden" class="shipdepot_package" name="shipdepot[package_id][]" value="` + id + `"/>
                        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-3 col-3"><input pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" type="text" name="shipdepot[` + id + `][length]"  class="package_length no-spin" id="` + id + `_package_length" /></div>
                        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-3 col-3"><input pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" type="text" name="shipdepot[` + id + `][width]" class="package_width no-spin" id="` + id + `_package_width" /></div>
                        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-3 col-3"><input pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" type="text" name="shipdepot[` + id + `][height]" class="package_height no-spin" id="` + id + `_package_height" /></div>
                        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-3 col-3"><input pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" type="text" name="shipdepot[` + id + `][weight]" class="package_weight no-spin" id="` + id + `_package_weight" /></div>
                    </div>
                </div>`;

            $div.html(inHtml);
            $div.appendTo("#package_size_container");
        });
    }

    if ($('#package_size_container').length > 0) {
        $("#package_size_container").on("click", ".btn_delete_package_size", function () {
            let divContent = $(this).parents('.package_size_row');
            divContent.remove();
            checkAndCalFee();
        });
    }

    if ($('#btn_expand_package').length > 0) {
        $("#btn_expand_package").click(function () {
            if ($('#package_content').is(':visible')) {
                $('#package_content').hide();
                $("#btn_expand_package").attr("src", `${sd_order_detail_params.sd_dir_url}assets/images/ic_down_arrow_black_16px.png`);
            } else {
                $('#package_content').show();
                $("#btn_expand_package").attr("src", `${sd_order_detail_params.sd_dir_url}assets/images/ic_up_arrow_black_16px.png`);
            }
        });
    }

    if ($('#package_content').length > 0) {
        $('#package_content').on('keyup', 'input[data-type=currency]', function () {
            formatCurrency($(this));
        });

        $('#package_content').on('blur', 'input[data-type=currency]', function () {
            formatCurrency($(this));
        });
    }

    if ($('#sl_storage').length > 0) {
        $("#sl_storage").change(function () {
            checkAndCalFee();
        });
    }

    if ($('#sl_receiver_province').length > 0) {
        $("#sl_receiver_province").change(function () {
            let province_code = this.value;
            let allProvinces = JSON.parse(sd_admin_address_params.all_provinces);
            $('#sl_receiver_ward').html('<option></option>').attr('disabled', 'disabled');
            html = '<option>' + sd_admin_address_params.l10n.select_district + '</option>';
            allProvinces.forEach(pro => {
                if (pro.Code == province_code) {
                    pro.ListDistricts.forEach(dis => {
                        html += '<option value="' + dis.Code + '">' + dis.Name + '</option>';
                    });
                }
            });
            $('#sl_receiver_district').html(html);
        });
    }

    if ($('#sl_receiver_district').length > 0) {
        $("#sl_receiver_district").change(function () {
            let province_code = $('#sl_receiver_province').val();
            let district_code = this.value;
            let allProvinces = JSON.parse(sd_admin_address_params.all_provinces);
            $('#sl_receiver_ward').html('<option></option>').removeAttr('disabled');
            html = '<option>' + sd_admin_address_params.l10n.select_ward + '</option>';
            allProvinces.forEach(pro => {
                if (pro.Code == province_code) {

                    pro.ListDistricts.forEach(dis => {
                        if (dis.Code == district_code) {
                            dis.ListWards.forEach(ward => {
                                html += '<option value="' + ward.Code + '">' + ward.Name + '</option>';
                            });
                        }
                    });

                }
            });
            $('#sl_receiver_ward').html(html);
        });
    }

    if ($('#sl_receiver_ward').length > 0) {
        $("#sl_receiver_ward").change(function () {
            checkAndCalFee();
        });
    }
    //Woocommerce shipping fields
    if ($('#_shipping_country').length > 0) {
        $("#_shipping_country").blur(function () {
            checkAndCalFee();
        });
    }

    if ($('#_shipping_city').length > 0) {
        $("#_shipping_city").blur(function () {
            checkAndCalFee();
        });
    }

    if ($('#_shipping_district').length > 0) {
        $("#_shipping_district").blur(function () {
            checkAndCalFee();
        });
    }

    if ($('#_shipping_ward').length > 0) {
        $("#_shipping_ward").change(function () {
            checkAndCalFee();
        });
    }

    if ($('#_shipping_last_name').length > 0) {
        $("#_shipping_last_name").blur(function () {
            checkAndCalFee();
        });
    }

    if ($('#_shipping_first_name').length > 0) {
        $("#_shipping_first_name").blur(function () {
            checkAndCalFee();
        });
    }

    if ($('#_shipping_address_1').length > 0) {
        $("#_shipping_address_1").blur(function () {
            checkAndCalFee();
        });
    }

    if ($('#_shipping_phone').length > 0) {
        $("#_shipping_phone").blur(function () {
            let orderID = $('#order_id').val();
            validateData(orderID);
        });
    }

    if ($('input[type=radio][class=rd_receiver_type]').length > 0) {
        $('input[type=radio][class=rd_receiver_type]').change(function () {
            if (this.value == 'current') {
                $('#receiver_info').hide();
            } else if (this.value == 'other') {
                $('#receiver_info').show();
            }
            checkAndCalFee();
        });
    }
    if ($('#cb_ins_fee').length > 0) {
        $("#cb_ins_fee").change(function () {
            if (this.checked) {
                $('#insr_price').show();
                //$('#tb_ins_fee').val('0');
            } else {
                $('#insr_price').hide();
                //$('#tb_ins_fee').val('');

            }
            checkAndCalFee();
        });
    }

    if ($('#cb_cod').length > 0) {
        $("#cb_cod").change(function () {
            if ($(this).is(':checked') == true) {
                $('#cod_price_content').show();
            } else {
                $('#cod_price_content').hide();
            }
            checkAndCalFee();
        });
    }

    if ($('#btn_expand_advance').length > 0) {
        $("#btn_expand_advance").click(function () {
            if ($('#advance_content').is(':visible')) {
                $('#advance_content').hide();
                $("#btn_expand_advance").attr("src", `${sd_order_detail_params.sd_dir_url}assets/images/ic_down_arrow_black_16px.png`);
            } else {
                $('#advance_content').show();
                $("#btn_expand_advance").attr("src", `${sd_order_detail_params.sd_dir_url}assets/images/ic_up_arrow_black_16px.png`);
            }
        });
    }

    if ($('#btn_reload_shipping_fee').length > 0) {
        $("#btn_reload_shipping_fee").click(function () {
            checkAndCalFee();
        });
    }

    if ($('#ship_depot_box').length > 0) {
        $('#ship_depot_box').on('change', 'input[type=radio][class=radio_shipping_fee]', function () {
            let orderID = $('#order_id').val();
            $('#is_select_shipping').val('true');
            console.log("[radio_shipping_fee] change => set is_select_shipping = true");
            updateShippingFee(orderID, false, $('#' + this.value).val(), fromNotCreateShip, true);
        });

        $('#ship_depot_box').on('change', 'input[type=text]', function () {
            checkAndCalFee();
        });

        $('#ship_depot_box').on('change', 'input[type=number]', function () {
            checkAndCalFee();
        });

        $('#ship_depot_box').on('change', 'input[data-type=currency]', function () {
            formatCurrency($(this));
            checkAndCalFee();
        });


    }
    //
    //recalculateTotal();
    //
    //Button function
    if ($('#btn_edit_shipping').length > 0) {
        $('#btn_edit_shipping').click(function () {
            if ($('#ship_depot_box').length > 0 && $('#ship_depot_box').css('display') == 'none') {
                $('#ship_depot_box').show();
            }
        });
    }

    if ($('#btn_cancel_shipping').length > 0) {
        $('#btn_cancel_shipping').click(function () {
            if (confirm(sd_order_detail_params.alert_messages.cancel_shipping)) {
                block($('#sd_meta_boxes'));
                let orderID = $('#order_id').val();
                jQuery.ajax({
                    url: sd_admin_address_params.ajax.url,
                    data: {
                        action: 'cancel_shipping',
                        orderID: orderID
                    },
                    type: 'POST',
                    success: function (response) {
                        if (response.data == "success") {
                            location.reload();
                        } else {
                            unblock($('#sd_meta_boxes'));
                            alert(response.data);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(sd_order_detail_params.error_messages.cancel_shipping);
                        console.log('[CancelShippingFee] error occured: ' + textStatus, errorThrown);
                        location.reload();
                    }
                });
            }
        });
    }

    //
    if ($('#myModal').length > 0) {
        if ($('#btnModalOK').length > 0) {
            $('#btnModalOK').click(function () {
                $("#ghtkHamlet").val($("#slGHTKHamlet").val());
                //$('#myModal').hide();
                saveOrder();
            });
        }

        if ($('#btnTestModal').length > 0) {
            $('#btnTestModal').click(function () {
                $('#myModal').show();
            });
        }
    }

    //Edit Cod Amount
    if ($('#btn_edit_cod').length > 0) {
        $('#btn_edit_cod').click(function () {
            $('#cod_info_area').css('display', 'none');
            $('#cod_edit_area').css('display', '');
        });
    }

    if ($('#btn_save_cod').length > 0) {
        $('#btn_save_cod').click(function () {
            if (isNullorEmpty($('#tb_cod_edit_amount').val())) {
                $('#tb_cod_edit_amount').addClass('error-class');
            } else {
                $('#tb_cod_edit_amount').removeClass('error-class');
                $('#is_cod_edit').val('true');
                saveOrder();
            }
        });
    }
    //
});