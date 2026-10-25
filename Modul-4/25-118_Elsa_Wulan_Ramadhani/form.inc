
<div class="container">
    <h2>Personal Information</h2>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
          method="POST">

        <div class="field">
            <label for="surname">Surname</label>
            <input type="text" id="surname" name="surname"
                value="<?php echo htmlspecialchars($_POST['surname'] ?? ''); ?>">
        </div>

        <div class="field">
            <label for="email">Email Address</label>
            <input type="text" id="email" name="email"
                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>

        <div class="field">
            <label for="address">Street Address</label>
            <textarea id="address" name="address" rows="3"><?php
                echo htmlspecialchars($_POST['address'] ?? '');
            ?></textarea>
        </div>

        <div class="field">
            <label for="state">State</label>
            <?php $state = $_POST['state'] ?? ''; ?>

            <select id="state" name="state">
                <option value="">Choose your state</option>
                <?php
                $states = [
                    'Queensland',
                    'Victoria',
                    'New South Wales',
                    'Tasmania',
                    'South Australia',
                    'Western Australia',
                    'Northern Territory',
                    'Australian Capital Territory'
                ];

                foreach ($states as $option) {
                    $selected = ($state === $option) ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($option) . '" '
                        . $selected . '>'
                        . htmlspecialchars($option)
                        . '</option>';
                }
                ?>
            </select>
        </div>

        <input type="hidden" name="country" value="Australia">

        <div class="field choice">
            <label>Gender</label>
            <?php $gender = $_POST['gender'] ?? ''; ?>

            <label>
                <input type="radio" name="gender" value="Male"
                    <?php if ($gender === 'Male') echo 'checked'; ?>> Male
            </label>

            <label>
                <input type="radio" name="gender" value="Female"
                    <?php if ($gender === 'Female') echo 'checked'; ?>> Female
            </label>
        </div>

        <div class="field choice">
            <label>Vegetarian?</label>
            <label>
                <input type="checkbox" name="vegetarian" value="Yes"
                    <?php if (isset($_POST['vegetarian'])) echo 'checked'; ?>> Yes
            </label>
        </div>

        <input type="submit" name="submit" value="Submit">
        <input type="reset" value="Reset">

    </form>
</div>
