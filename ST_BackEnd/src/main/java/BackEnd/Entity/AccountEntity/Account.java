package BackEnd.Entity.AccountEntity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.security.core.GrantedAuthority;
import org.springframework.security.core.authority.SimpleGrantedAuthority;
import org.springframework.security.core.userdetails.UserDetails;

import java.time.LocalDateTime;
import java.util.Collection;
import java.util.List;

@Data
@NoArgsConstructor
@AllArgsConstructor
@Entity
@Table(name = "Account")
public class Account implements UserDetails {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @NotBlank(message = "Password cannot be blank")
    @Column(nullable = false)
    private String password;

    @Column(name = "CreateAt", nullable = false, updatable = false)
    private LocalDateTime createAt = LocalDateTime.now();

    @Column(name = "Status", nullable = false)
    private Boolean status = true;

    @Column(name = "Active", nullable = false)
    private Boolean active = false;

    @Enumerated(EnumType.STRING)
    @Column(name = "Role", nullable = false)
    private Role role = Role.User;

    @Enumerated(EnumType.STRING)
    @Column(name = "Type", nullable = false)
    private AccountType type = AccountType.WEB;

    @OneToOne
    @JoinColumn(name = "UserInformationId", nullable = false)
    private UserInformation userInformation;

    @Override
    public Collection<? extends GrantedAuthority> getAuthorities() {
        return List.of(new SimpleGrantedAuthority(role.name()));
    }

    @Override
    public String getUsername() {
        return getUserInformation().getEmail();
    }

    @Override
    public boolean isAccountNonExpired() {
        return true;
    }

    @Override
    public boolean isAccountNonLocked() {
        return true;
    }

    @Override
    public boolean isCredentialsNonExpired() {
        return true;
    }

    @Override
    public boolean isEnabled() {
        return status;
    }

    public enum Role {
        User, Admin
    }

    public enum AccountType {
        FACEBOOK, GOOGLE, WEB, OTHER
    }

}
