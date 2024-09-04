package BackEnd.Entity.AccountEntity;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.util.List;


@Entity
@Data
@NoArgsConstructor
@AllArgsConstructor
public class TokenType {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @Column(nullable = false, unique = true)
    private String tokenTypeName;

    @OneToMany(mappedBy = "tokenType", cascade = CascadeType.ALL)
    private List<Token> tokens;

}

