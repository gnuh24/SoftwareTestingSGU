package BackEnd.Service.ShoppingServices.VoucherServices;

import BackEnd.Entity.ShoppingEntities.Voucher;
import BackEnd.Form.ShoppingForms.VoucherForms.VoucherCreateForm;
import BackEnd.Form.ShoppingForms.VoucherForms.VoucherFilterForm;
import BackEnd.Form.ShoppingForms.VoucherForms.VoucherUpdateForm;
import BackEnd.Repository.ShoppingRepositories.IVoucherRepository;
import BackEnd.Specification.ShoppingSpecifications.VoucherSpecification;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.time.LocalDateTime;
import java.util.List;

@Service
public class VoucherService implements IVoucherService {

    @Autowired
    private IVoucherRepository voucherRepository;

    @Autowired
    private ModelMapper modelMapper;

    @Override
    public Voucher getVoucherById(Integer voucherId) {
        return voucherRepository.findById(voucherId).orElse(null);
    }

    @Override
    public Page<Voucher> getAllVoucherByAdmin(Pageable pageable, VoucherFilterForm form, String search) {
        Specification<Voucher> where = VoucherSpecification.buildWhere(search, form);
        return voucherRepository.findAll(where, pageable);
    }

    @Override
    public List<Voucher> getAllVoucherByUser() {
        return voucherRepository.getVoucherByUser();
    }

    @Override
    @Transactional
    public Voucher createVoucher(VoucherCreateForm form) {
        Voucher voucher = modelMapper.map(form, Voucher.class);
        return voucherRepository.save(voucher);
    }

    @Override
    @Transactional
    public Voucher updateVoucher(VoucherUpdateForm form) {
        Voucher voucher = getVoucherById(form.getVoucherId());
        if (voucher != null) {
            if (form.getTitle() != null) {
                voucher.setTitle(form.getTitle());
            }
            if (form.getStatus() != null) {
                voucher.setStatus(form.getStatus());
            }
            if (form.getExpirationTime() != null) {
                voucher.setExpirationTime(form.getExpirationTime());
            }
            if (form.getDiscountAmount() != null) {
                voucher.setDiscountAmount(form.getDiscountAmount());
            }
            if (form.getCondition() != null) {
                voucher.setCondition(form.getCondition());
            }
            if (form.getIsFreeShip() != null) {
                voucher.setIsFreeShip(form.getIsFreeShip());
            }
            return voucherRepository.save(voucher);
        }
        return null;
    }

    @Override
    public Boolean isVoucherExpirated(Voucher voucher) {
        return voucher.getExpirationTime().isBefore(LocalDateTime.now());
    }

    @Override
    public Boolean isVoucherExpirated(Integer voucherId) {
        Voucher voucher = getVoucherById(voucherId);
        return voucher != null && isVoucherExpirated(voucher);
    }

    @Override
    public Integer numberOfOrder(Voucher voucher) {
        // Implement logic to count the number of orders using this voucher
        return 0; // Placeholder
    }

    @Override
    public Integer numberOfOrder(Integer voucherId) {
        Voucher voucher = getVoucherById(voucherId);
        return voucher != null ? numberOfOrder(voucher) : 0;
    }

    @Override
    public Voucher getVoucherByCode(String code) {

        return voucherRepository.findByCode(code);
    }
}
