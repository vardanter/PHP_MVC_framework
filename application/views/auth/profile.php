<div class="profile__container">

    <div class="profile__image">
        <img src="/uploads/<?= $user->avatar ?>" />
    </div>
    <div class="profile__info">
        <h1><?= $user->getProfile()->fullname ?></h1>
        <ul>
            <li class="profile__info-row">
                <div class="info-prop">Email:</div>
                <div class="info-data"><?= $user->email ?></div>
            </li>
            <li class="profile__info-row">
                <div class="info-prop">Phone:</div>
                <div class="info-data"><?= $user->phone ?></div>
            </li>
            <li class="profile__info-row">
                <div class="info-prop">Create date:</div>
                <div class="info-data"><?= date("d.m.Y H:i", strtotime($user->create_date)) ?></div>
            </li>
        </ul>
    </div>
</div>