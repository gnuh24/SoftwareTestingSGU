package BackEnd.Entity.AccountEntity;

import jakarta.persistence.*;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

@Data
@NoArgsConstructor
@Entity
@Table(name = "Token")
public class Token {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @Column(nullable = false, unique = true, length = 36)
    private String token;

    @Column(nullable = false)
    private LocalDateTime expiration;

    @Column(name = "CreateTime", nullable = false, updatable = false)
    private LocalDateTime createTime;

    @ManyToOne
    @JoinColumn(name = "tokenTypeId", nullable = false)
    private TokenType tokenType;

    @ManyToOne
    @JoinColumn(name = "accountId", nullable = false)
    private Account account;

    @PrePersist
    void prePersists() {
        if (expiration == null) {
            // Set expiration time to 2 hours from now
            expiration = LocalDateTime.now().plusHours(2);
        }
        if (createTime == null) {
            // Set creation time to the current time
            createTime = LocalDateTime.now();
        }
    }
}
