package BackEnd.Repository.ShoppingRepositories;


import BackEnd.Entity.ShoppingEntities.Event;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.time.LocalDateTime;
import java.util.List;

public interface IEventRepository extends JpaRepository<Event, Integer>, JpaSpecificationExecutor<Event> {
    @Query("SELECT e FROM Event e WHERE e.startTime <= :currentTime AND e.endTime >= :currentTime AND e.status = true")
    Event findCurrentEvent(LocalDateTime currentTime);

    @Query("SELECT e FROM Event e WHERE e.status = true AND e.startTime >= :now")
    List<Event> findFutureActiveEvents(LocalDateTime now);
}

