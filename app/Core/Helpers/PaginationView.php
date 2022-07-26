<nav>
    <ul class="pagination justify-content-center">
        <li class="page-item">
            <a class="page-link" href="/<?= $paginationUrl?>?list=1">
                Первая
            </a>
        </li>

        <li class="page-item">
            <a class="page-link" href="/<?= $paginationUrl?>?list=<?= $_GET['list']-1 ?>"><<</a>
        </li>

        <?php if(!($_GET['list'] < 3)): ?>
            <li class="page-item">
                <a class="page-link" href="/<?= $paginationUrl?>?list=<?= $_GET['list']-2 ?>"><?= $_GET['list']-2 ?></a>
            </li>
        <?php endif ?>

        <?php if(!($_GET['list'] < 2)): ?>
            <li class="page-item">
                <a class="page-link" href="/<?= $paginationUrl?>?list=<?= $_GET['list']-1 ?>"><?= $_GET['list']-1 ?></a>
            </li>
        <?php endif ?>

        <li class="page-item active">
            <a class="page-link" href="/<?= $paginationUrl?>?list=<?= $_GET['list'] ?>"><?= $_GET['list'] ?></a>
        </li>

        <?php if(!($_GET['list']+1 > ceil($recordCount / $PageCount))): ?>
            <li class="page-item">
                <a class="page-link" href="/<?= $paginationUrl?>?list=<?= $_GET['list']+1 ?>"><?= $_GET['list']+1 ?></a>
            </li>
        <?php endif ?>

        <?php if(!($_GET['list']+2 > ceil($recordCount / $PageCount))): ?>
            <li class="page-item">
                <a class="page-link" href="/<?= $paginationUrl?>?list=<?= $_GET['list']+2 ?>"><?= $_GET['list']+2 ?></a>
            </li>
        <?php endif ?>

        <li class="page-item">
            <a class="page-link" href="/<?= $paginationUrl?>?list=<?= $_GET['list']+1 ?>">>></a>
        </li>

        <li class="page-item">
            <a class="page-link" href="/<?= $paginationUrl?>?list=<?= ceil($recordCount / $PageCount) ?>">
                Последняя
            </a>
        </li>
        <form method="get">
            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="PageRows" onchange="form.submit();">
                <option value="10" <?php if ($_SESSION['PageRows'] == 10) {echo "selected";}?>>10</option>
                <option value="25" <?php if ($_SESSION['PageRows'] == 25) {echo "selected";}?>>25</option>
                <option value="50" <?php if ($_SESSION['PageRows'] == 50) {echo "selected";}?>>50</option>
            </select>
        </form>
    </ul>
</nav>