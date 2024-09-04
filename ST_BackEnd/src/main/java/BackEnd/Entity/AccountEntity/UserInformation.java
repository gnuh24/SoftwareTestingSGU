package BackEnd.Entity.AccountEntity;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDate;

@Entity
@Table(name = "UserInformation")
@Data
@NoArgsConstructor
@AllArgsConstructor
public class UserInformation {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "Id", nullable = false)
    private Integer id;

    @Column(name = "Email", unique = true)
    private String email;

    @Column(name = "Address")
    private String address;

    @Column(name = "Birthday")
    private LocalDate birthday;

    @Column(name = "Fullname")
    private String fullname;

    @Enumerated(EnumType.STRING)
    @Column(name = "Gender", length = 6)
    private Gender gender;

    @Column(name = "PhoneNumber", length = 20, unique = true)
    private String phoneNumber;

    @OneToOne(mappedBy = "userInformation", cascade = CascadeType.ALL, fetch = FetchType.LAZY)
    private Account account;

    public enum Gender {
        Male, Female, Other
    }
}
