<header class="Home-container-header">
            <div id="Home-over-Header">
                <img id="Home-img" src="img/logoWine.jpg" alt="" />
                <form class="input__wrapper">
                <?php
                    if (isset($_GET['searchFromAnotherPage'])) {
                        echo '<input value="' . $_GET['searchFromAnotherPage'] . '" id="searchSanPham" type="text" class="search-input" placeholder="Tìm kiếm" required/>';
                    } else {
                        echo '<input id="searchSanPham" type="text" class="search-input" placeholder="Tìm kiếm" required/>';
                    }
                ?>

                    <button id="filter-button"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <div id="Home-login">Login</div>
            </div>
        </header>