package BackEnd.Repository.NewsRepositories;

import BackEnd.Entity.NewsEntities.News;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;
import org.springframework.stereotype.Repository;

import java.util.List;

public interface INewsRepository extends JpaRepository<News, Integer>, JpaSpecificationExecutor<News> {

    List<News> findByPriorityFlag(Boolean status);
}

