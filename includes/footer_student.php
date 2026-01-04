<?php
// includes/footer_student.php
?>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const body = document.body;
            
            // Load saved state
            const savedState = localStorage.getItem('sidebar-state') || 'expanded';
            body.setAttribute('data-sidebar', savedState);

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    const currentState = body.getAttribute('data-sidebar');
                    const newState = currentState === 'expanded' ? 'collapsed' : 'expanded';
                    body.setAttribute('data-sidebar', newState);
                    localStorage.setItem('sidebar-state', newState);
                });
            }
        });
    </script>
</body>
</html>
