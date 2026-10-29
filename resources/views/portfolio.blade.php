<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $content['about']->title ?? 'Interactive Portfolio' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --sky: #82d8ff; --ink: #132238; --brick: #cb542d; }
        body { margin: 0; background: var(--sky); color: var(--ink); font-family: system-ui, sans-serif; }
        #game { min-height: 100vh; display: grid; place-items: center; padding: 1rem; }
        #game canvas { width: min(100%, 1100px); height: auto; border: 4px solid var(--ink); border-radius: .75rem; box-shadow: 0 1rem 2rem #14324b44; image-rendering: pixelated; }
        .overlay-help { position: fixed; inset: auto 1rem 1rem auto; max-width: 20rem; }
    </style>
</head>
<body>
<main id="game" aria-label="Interactive portfolio game"></main>
<div class="overlay-help alert alert-light shadow-sm small mb-0">
    <strong>Controls:</strong> Arrow keys / A-D to move, Space to jump. Explore the level to open the portfolio.
</div>
<div class="modal fade" id="aboutModal" tabindex="-1" aria-labelledby="aboutTitle" aria-hidden="true">
    <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h2 class="modal-title fs-5" id="aboutTitle">{{ $content['about']->title ?? 'About' }}</h2><button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body">{{ $content['about']->body ?? 'Welcome.' }}</div></div></div>
</div>
<div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h2 class="modal-title fs-5" id="projectTitle"></h2><button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body" id="projectBody"></div></div></div>
</div>
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactTitle" aria-hidden="true">
    <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h2 class="modal-title fs-5" id="contactTitle">{{ $content['contact']->title ?? 'Contact' }}</h2><button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><p>{{ $content['contact']->body ?? 'Let us connect.' }}</p><a class="btn btn-primary" href="mailto:hello@example.com">Send email</a></div></div></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/kaboom@3000.1.17/dist/kaboom.js"></script>
<script>
const skills = @json($skills);
const projects = @json($projects);
const experiences = @json($experiences);
const game = kaboom({ root: document.querySelector('#game'), width: 1100, height: 620, background: [130, 216, 255], crisp: true });
const gravity = 1800;
const levelWidth = 3400;
setGravity(gravity);
loadSprite('hero', 'https://kaboomjs.com/sprites/bean.png');
loadSprite('enemy', 'https://kaboomjs.com/sprites/ghosty.png');
loadSprite('brick', 'https://kaboomjs.com/sprites/brick.png');
loadSprite('question', 'https://kaboomjs.com/sprites/question.png');
loadSprite('steel', 'https://kaboomjs.com/sprites/steel.png');
loadSprite('pipe', 'https://kaboomjs.com/sprites/grass.png');
loadSprite('flag', 'https://kaboomjs.com/sprites/flag.png');

function platform(pos, width = 120) {
    add([sprite('brick'), pos, area(), body({ isStatic: true }), scale(width / 16, 1), 'platform']);
}
function showModal(id) { bootstrap.Modal.getOrCreateInstance(document.querySelector(id)).show(); }
function projectDetails(project) {
    document.querySelector('#projectTitle').textContent = project.title;
    document.querySelector('#projectBody').innerHTML = `<p>${project.description ?? project.summary}</p>${project.url ? `<a href="${project.url}" target="_blank" rel="noopener" class="btn btn-primary">Open project</a>` : ''}`;
    showModal('#projectModal');
}
scene('portfolio', () => {
    const player = add([sprite('hero'), pos(120, 420), area(), body(), anchor('center'), 'player']);
    const score = add([text('Bugs fixed: 0', { size: 24 }), pos(24, 24), fixed(), z(10)]);
    let bugsFixed = 0;
    platform(vec2(0, 570), levelWidth);
    [520, 910, 1400, 2050, 2700].forEach((x) => platform(vec2(x, 430), 150));
    add([text('ABOUT', { size: 18 }), pos(340, 365), area(), 'aboutNpc']);
    onCollide('player', 'aboutNpc', () => showModal('#aboutModal'));
    skills.forEach((skill, index) => {
        const x = 700 + index * 190;
        add([sprite('question'), pos(x, 330), area(), 'skillBlock', { skill }]);
        add([text(skill.name, { size: 16 }), pos(x - 20, 365)]);
    });
    projects.forEach((project, index) => {
        const x = 1250 + index * 230;
        add([sprite('pipe'), pos(x, 485), area(), 'projectPipe', { project }]);
    });
    experiences.forEach((experience, index) => {
        const x = 2100 + index * 260;
        add([sprite('question'), pos(x, 300), area(), 'experienceBlock', { experience }]);
    });
    for (let index = 0; index < Math.max(3, projects.length); index++) {
        const x = 1550 + index * 260;
        add([sprite('enemy'), pos(x, 510), area(), move(LEFT, 50), 'bug']);
    }
    add([sprite('flag'), pos(levelWidth - 180, 400), area(), 'flagpole']);
    onCollide('player', 'bug', (bug) => {
        if (player.pos.y < bug.pos.y - 10) { destroy(bug); bugsFixed++; score.text = `Bugs fixed: ${bugsFixed}`; player.jump(650); }
    });
    onCollide('player', 'skillBlock', (block) => debug.log(`Skill: ${block.skill.name}`));
    onCollide('player', 'projectPipe', (pipe) => projectDetails(pipe.project));
    onCollide('player', 'experienceBlock', () => showModal('#aboutModal'));
    onCollide('player', 'flagpole', () => showModal('#contactModal'));
    onKeyDown(['left', 'a'], () => player.move(-260, 0));
    onKeyDown(['right', 'd'], () => player.move(260, 0));
    onKeyPress(['space', 'up', 'w'], () => { if (player.isGrounded()) player.jump(700); });
    onUpdate(() => {
        camPos(player.pos.x, height() / 2);
        player.pos.x = clamp(player.pos.x, 20, levelWidth - 20);
    });
});
go('portfolio');
</script>
</body>
</html>
