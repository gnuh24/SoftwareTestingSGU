package BackEnd.Entity.AccountEntity;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

@Data
@NoArgsConstructor
@AllArgsConstructor
@Entity
public class Token {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @Column(nullable = false, unique = true, length = 36)
    private String token;

    @Column(nullable = false)
    private LocalDateTime expiration = LocalDateTime.now().plusHours(2);

    @Column(name = "CreateTime", nullable = false, updatable = false)
    private LocalDateTime createTime = LocalDateTime.now();;

    @ManyToOne
    @JoinColumn(name = "tokenTypeId", nullable = false)
    private TokenType tokenType;

    @ManyToOne
    @JoinColumn(name = "accountId", nullable = false)
    private Account account;

}
