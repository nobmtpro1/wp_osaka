// GHN
var orderCode = null;
const buttonSubmitCreateOrder = document.querySelector(
  ".button.devvn_ghn_creat_order"
);
if (buttonSubmitCreateOrder) {
  buttonSubmitCreateOrder?.removeAttribute("href");
}
const buttonOpenPopupCreateOrder = document.querySelector(
  ".button.ghn_creat_order_popup"
);
const ghnAction = document.getElementById("ghn-action-id");
if (ghnAction) {
  const urlParams = new URLSearchParams(window.location.search);
  const order_id = urlParams.get("post");
  wp.ajax
    .post("check_ghn_order", { order_id })
    .done(function (response) {
      orderCode = response?.order_code;
      if (orderCode) {
        const inside = ghnAction?.querySelector(".inside");
        const element = document.createElement("div");
        element.innerHTML =
          "Đơn hàng đã được tạo vận đơn. Mã đơn hàng: " + orderCode;
        element.style.marginBottom = "20px";
        element.style.color = "green";
        element.style.fontSize = "20px";
        inside?.insertBefore(element, inside.firstChild);

        const deleteButton = document.createElement("a");
        deleteButton.className = "submitdelete deletion ghn_delete_order";
        deleteButton.innerHTML = "Xóa vận đơn";
        deleteButton.style.marginTop = "20px";
        deleteButton.style.color = "#b32d2e";
        deleteButton.style.display = "block";
        deleteButton.setAttribute("href", "#");
        inside?.appendChild(deleteButton);
        buttonSubmitCreateOrder.innerHTML = "Sửa vận đơn";
        buttonOpenPopupCreateOrder.innerHTML = "Sửa vận đơn";
        buttonOpenPopupCreateOrder.classList.remove("button");
        buttonOpenPopupCreateOrder.classList.remove("button-primary");
        console.log(response);
      }
    })
    .fail(function (error) {
      console.log(error);
    });
}

document.querySelector("body").addEventListener("click", function (e) {
  if (e.target && e.target.classList.contains("devvn_ghn_creat_order")) {
    e.stopImmediatePropagation();
    const urlParams = new URLSearchParams(window.location.search);
    const order_id = urlParams.get("post");
    const data = {
      order_id: order_id,
      client_order_code: document.querySelector("#ghn_ExternalCode")?.value,
      shop_id: document.querySelector("#ghn_creatorder_hub")?.value,
      insurance_value: document.querySelector("#ghn_InsuranceFee")?.value,
      is_insurance_value: document.querySelector("#ghn_khaigia")?.value,
      weight: document.querySelector("#ghn_order_weight")?.value,
      length: document.querySelector("#ghn_order_length")?.value,
      width: document.querySelector("#ghn_order_width")?.value,
      height: document.querySelector("#ghn_order_height")?.value,
      required_note: document.querySelector("#ghn_ghichu_required")?.value,
      note: document.querySelector("#ghn_ghichu")?.value,
      payment_type_id: document.querySelector(
        `input[name="ghn_PaymentTypeID"]:checked`
      )?.value,
      cod_amount: document.querySelector("#ghn_tienthuho")?.value,
      service_id: document.querySelector(`input[name="ghn_services"]:checked`)
        ?.value,
      is_pick_station: document.querySelector(
        `input[name="ghn_isPickAtStation"]:checked`
      )?.value,
      order_code: orderCode,
    };

    console.log(data);

    const body = document.querySelector("body");
    body.classList.add("ghn_loading");
    wp.ajax
      .post(orderCode ? "update_ghn_order" : "create_ghn_order", data)
      .done(function (response) {
        location.reload();
      })
      .fail(function (error) {
        body.classList.remove("ghn_loading");
        alert(error?.message);
      });
  }
});

document.querySelector("body").addEventListener("click", function (e) {
  if (e.target && e.target.classList.contains("ghn_delete_order")) {
    e.stopImmediatePropagation();
    const urlParams = new URLSearchParams(window.location.search);
    const order_id = urlParams.get("post");
    const data = {
      order_id: order_id,
      order_code: orderCode,
    };
    e.target.innerHTML = "Đang xóa vận đơn...";
    e.target.style.pointerEvents = "none";
    wp.ajax
      .post("cancel_ghn_order", data)
      .done(function (response) {
        location.reload();
      })
      .fail(function (error) {
        e.target.innerHTML = "Xóa vận đơn";
        e.target.style.pointerEvents = "unset";
        alert(error?.message);
      });
  }
});

// remove notice
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
