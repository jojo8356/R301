</main>
<footer class="footer">
  <div class="footer-inner">
    <div>© <?= date('Y') ?> — R301 Programmation Web « Côté Serveur » · TD n°4 (séance 4)</div>
    <div>PHP <?= PHP_VERSION ?> · <a href="index.php">Retour à l'accueil</a></div>
  </div>
</footer>
<script>
function copierCode(btn) {
  const block = btn.closest('.code-block');
  const code = block.querySelector('pre') ? block.querySelector('pre').innerText : '';
  navigator.clipboard.writeText(code).then(() => {
    btn.textContent = 'Copié ✓';
    btn.classList.add('copied');
    setTimeout(() => { btn.textContent = 'Copier'; btn.classList.remove('copied'); }, 1600);
  });
}
</script>
</body>
</html>
