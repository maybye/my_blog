</td>
<td width="300px" class="sidebar">
    <div class="sidebarHeader">Меню</div>
    <ul>
        <li><a href="/project/project/www/">Главная страница</a></li>
        <li><a href="/project/project/www/article/create">Добавить статью</a></li>
        <li><a href="/project/project/www/about-me">Обо мне</a></li>
        <?php if (!isset($_SESSION['nickname'])): ?>
            <p><a href="login.php">Login</a> | <a href="register.php">Register</a></p>
        <?php else: ?>
            <p><a href="logout/logout.php">Log Out</a></p>
        <?php endif; ?>
    </ul>
</td>
</tr>
<tr>
<td class="footer" colspan="2">Все права защищены (c) Мой блог</td>
</tr>
</table>
</main>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>