package BackEnd.Service.ShoppingServices.VoucherServices;

import BackEnd.Entity.ShoppingEntities.Voucher;
import BackEnd.Form.ShoppingForms.VoucherForms.VoucherCreateForm;
import BackEnd.Form.ShoppingForms.VoucherForms.VoucherFilterForm;
import BackEnd.Form.ShoppingForms.VoucherForms.VoucherUpdateForm;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import java.util.List;

public interface IVoucherService {

    Voucher getVoucherById(Integer voucherId);
    Page<Voucher> getAllVoucherByAdmin(Pageable pageable, VoucherFilterForm form, String search);
    List<Voucher> getAllVoucherByUser();
    Voucher createVoucher(VoucherCreateForm form);
    Voucher updateVoucher(VoucherUpdateForm form);
    Boolean isVoucherExpirated(Voucher voucher);
    Boolean isVoucherExpirated(Integer voucherId);
    Integer numberOfOrder(Voucher voucher);
    Integer numberOfOrder(Integer voucherId);

    Voucher getVoucherByCode(String code);
}
