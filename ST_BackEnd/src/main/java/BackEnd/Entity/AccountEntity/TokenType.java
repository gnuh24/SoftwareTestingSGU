package BackEnd.Entity.AccountEntity;

import jakarta.persistence.*;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.util.List;

@Data
@NoArgsConstructor
@Entity
@Table(name = "TokenType")
public class TokenType {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @Column(nullable = false, unique = true)
    private String tokenTypeName;

    @OneToMany(mappedBy = "tokenType", cascade = CascadeType.ALL)
    private List<Token> tokens;

}

