<?php include('header.php'); ?>
<div class="container my-5">
    <h2 class="text-center mb-4">Mess Timings and Menus</h2>

    <!-- Mess Timing -->
    <div class="row">
        <div class="col-md-6">
            <h4>Mess Timing</h4>
            <ul class="list-group">
                <li class="list-group-item">Breakfast: 7:00 AM - 9:00 AM</li>
                <li class="list-group-item">Lunch: 12:30 PM - 2:00 PM</li>
                <li class="list-group-item">Dinner: 7:00 PM - 9:00 PM</li>
            </ul>
        </div>

        <!-- Today's Menu -->
        <div class="col-md-6">
            <h4>Today's Menu</h4>
            <ul class="list-group">
                <li class="list-group-item">Breakfast: Poha, Tea</li>
                <li class="list-group-item">Lunch: Chapati, Rice, Dal, Vegetable</li>
                <li class="list-group-item">Dinner: Rice, Vegetable, Salad</li>
            </ul>
            <button class="btn btn-primary mt-3" onclick="toggleFullMenu('today')">View Full Week Menu</button>
        </div>
    </div>

    <!-- Tomorrow's Menu -->
    <div class="row mt-5">
        <div class="col-md-6">
            <h4>Tomorrow's Menu</h4>
            <ul class="list-group">
                <li class="list-group-item">Breakfast: Paratha, Curd</li>
                <li class="list-group-item">Lunch: Rice, Gravy, Paneer</li>
                <li class="list-group-item">Dinner: Chapati, Daal, Vegetable</li>
            </ul>
            <button class="btn btn-primary mt-3" onclick="toggleFullMenu('tomorrow')">View Full Week Menu</button>
        </div>

        <!-- Full Week Menu and Important Notes (Initially hidden) -->
        <div id="fullWeekMenu" class="col-12 mt-5" style="display: none;">
            <div class="row">
                <div class="col-md-6">
                    <h4>Full Week Menu</h4>
                    <div class="scrolling-container">
                        <ul class="list-group">
                            <li class="list-group-item">Monday: Breakfast - Poha, Lunch - Rice, Vegetable, Dinner - Chapati</li>
                            <li class="list-group-item">Tuesday: Breakfast - Paratha, Lunch - Dal, Rice, Dinner - Rice</li>
                            <li class="list-group-item">Wednesday: Breakfast - Cereal, Lunch - Paneer, Chapati, Dinner - Vegetable</li>
                            <li class="list-group-item">Thursday: Breakfast - Toast, Lunch - Rice, Daal, Dinner - Naan</li>
                            <li class="list-group-item">Friday: Breakfast - Sandwich, Lunch - Gravy, Chapati, Dinner - Soup</li>
                            <li class="list-group-item">Saturday: Breakfast - Idli, Lunch - Rice, Vegetable, Dinner - Chapati</li>
                            <li class="list-group-item">Sunday: Breakfast - Dosa, Lunch - Biryani, Dinner - Rice & Gravy</li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-6">
                    <h4>Important Notes</h4>
                    <div class="scrolling-container">
                        <ul class="list-group">
                            <li class="list-group-item">All meals are subject to availability.</li>
                            <li class="list-group-item">Please inform in advance if you have any dietary restrictions.</li>
                            <li class="list-group-item">Meal timings are fixed. Please adhere to the schedule.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Buttons for Profile and Feedback -->
    <div class="row mt-5">
        <div class="col-md-4">
            <a href="edit-profile.php" class="btn btn-warning w-100">Edit Profile</a>
        </div>
        <div class="col-md-4">
            <a href="fees-status.php" class="btn btn-info w-100">View Fees Status</a>
        </div>
        <div class="col-md-4">
            <a href="submit-feedback.php" class="btn btn-success w-100">Submit Feedback</a>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

