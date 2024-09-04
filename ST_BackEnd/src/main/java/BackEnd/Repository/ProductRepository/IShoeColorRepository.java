package BackEnd.Repository.ProductRepository;

import BackEnd.Entity.ProductEntity.ShoeColor;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;

import java.util.List;

public interface IShoeColorRepository extends JpaRepository<ShoeColor, ShoeColor.ShoeColorId> {
    @Modifying
    @Query("DELETE FROM ShoeColor sc WHERE sc.id.colorId = :colorId")
    void deleteByColorId( Integer colorId);
}
