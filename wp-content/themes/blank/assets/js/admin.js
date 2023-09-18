document.querySelector("body").addEventListener("click", function (e) {
  if (e.target && e.target.classList.contains("devvn_ghn_creat_order")) {
    e.stopImmediatePropagation();
    const urlParams = new URLSearchParams(window.location.search);
    const order_id = urlParams.get("post");
    const data = {
      order_id: order_id,
      client_order_code: document.querySelector("#ghn_ExternalCode").value,
      shop_id: document.querySelector("#ghn_creatorder_hub").value,
      insurance_value: document.querySelector("#ghn_InsuranceFee").value,
      is_insurance_value: document.querySelector("#ghn_khaigia").value,
      weight: document.querySelector("#ghn_order_weight").value,
      length: document.querySelector("#ghn_order_length").value,
      width: document.querySelector("#ghn_order_width").value,
      height: document.querySelector("#ghn_order_height").value,
      required_note: document.querySelector("#ghn_ghichu_required").value,
      note: document.querySelector("#ghn_ghichu").value,
      payment_type_id: document.querySelector(
        `input[name="ghn_PaymentTypeID"]:checked`
      ).value,
      cod_amount: document.querySelector("#ghn_tienthuho").value,
      service_id: document.querySelector(`input[name="ghn_services"]:checked`)
        .value,
      is_pick_station: document.querySelector(
        `input[name="ghn_isPickAtStation"]:checked`
      ).value,
    };

    console.log(data);

    const body = document.querySelector("body");
    body.classList.add("ghn_loading");
    wp.ajax
      .post("create_ghn_order", data)
      .done(function (response) {
        location.reload();
      })
      .fail(function (error) {
        body.classList.remove("ghn_loading");
        alert(error?.message);
      });
  }
});

const noticeErrors = document.querySelectorAll(".notice.notice-error p");
noticeErrors?.forEach((e) => {
  console.log(e?.textContent);
  if (
    e?.textContent ==
    "Hãy điền License Key để tự động cập nhật khi có phiên bản mới. Thêm tại đây"
  ) {
    e?.parentElement?.remove();
  }
});
