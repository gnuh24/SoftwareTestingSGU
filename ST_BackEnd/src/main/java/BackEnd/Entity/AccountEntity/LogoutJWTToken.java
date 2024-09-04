package BackEnd.Entity.AccountEntity;


import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

@Entity
@Table(name = "LogoutJWTToken")
@Data
@NoArgsConstructor
@AllArgsConstructor
public class LogoutJWTToken {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @Column(name = "Token", nullable = false, unique = true, length = 255)
    private String token;

    @Column(name = "LogoutTime", nullable = false)
    private LocalDateTime logoutTime = LocalDateTime.now();


}

