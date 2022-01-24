<?php if(!$is_logged_in): ?>

<div id="settings-pane">
    <div id="settings-breadcumb">ERROR: No tienes ninguna sesión iniciada.</div>
</div>

<?php else: ?>
<script src="js/mod.js"></script>
<div id="settings-pane">
    <div id="settings-breadcumb"></div>
    <div id="settings-stuff">
        <div id="config-section-1" class="config-section">
        <h3 class="title-panel">Administración de usuarios</h3>
        <div class="mod-search">
            <h5>Buscar usuarios: </h5>
            <input type="text" id="mod-search-box"><button id="mod-search-button">Buscar</button>
        </div>
        <h3 class="title-panel">Resultados</h3>
        <div class="follower-list" id="search-results">
                <div class="scrollhide">
                </div>
            </div>
        </div>
        <div id="config-section-2" class="config-section">
        <h3 class="title-panel">Mensajes reportados</h3>
        <div class="reported-list">
                <div class="scrollhide">
                    <?php
                        echo $qlib->getReported();
                    ?>
        </div>
        </div>
        <div id="config-section-3" class="config-section">
        <h3 class="title-panel">Baneos</h3>
        <div class="follower-list" id="ban-results">
                <div class="scrollhide">
                    <?php
                        $banned = $qlib->getBannedUsers();
                        if($banned)
                            foreach($banned as $ban)
                                echo $ban;
                    ?>
                </div>
            </div>
        </div>
        </div>
        <div id="config-section-4" class="config-section">
        <h3 class="title-panel">D</h3>
        </div>
        <div id="config-section-5" class="config-section">
        <h3 class="title-panel">E</h3>
        </div>
        <div id="config-section-6" class="config-section">
        <h3 class="title-panel">F</h3>
        </div>
    </div>
</div>
<?php endif; ?>
