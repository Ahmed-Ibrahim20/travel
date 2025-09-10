/**
 * Booking Modal JavaScript Functionality
 * Professional booking system with multi-step payment process
 */

// Global variables for booking modal
let selectedPaymentType = "";
let selectedRatePlan = null;
let dateFrom, dateTo, childrenEl, roomTypeEl;
let pkgLabel, pkgPrice, nightsVal, peopleVal, totalVal;
let bookingModalEl, bookingForm;

/**
 * Show professional toast notification
 */
function showToast(message, type = 'success', duration = 3000) {
    const toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) return;

    const toastId = 'toast-' + Date.now();
    const iconClass = type === 'success' ? 'fa-check-circle text-success' : 'fa-exclamation-triangle text-danger';
    const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
    
    const toastHTML = `
        <div class="toast align-items-center text-white ${bgClass} border-0" role="alert" id="${toastId}" data-bs-autohide="true" data-bs-delay="${duration}">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center">
                    <i class="fas ${iconClass} me-2"></i>
                    <span>${message}</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
    
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement);
    toast.show();
    
    // Remove toast element after it's hidden
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
}

document.addEventListener("DOMContentLoaded", function () {
    // Initialize elements
    initializeBookingElements();

    // Setup event listeners
    setupBookingEventListeners();

    // Setup payment method listeners
    setupPaymentMethodListeners();
});

/**
 * Initialize all booking modal elements
 */
function initializeBookingElements() {
    dateFrom = document.getElementById("dateFrom");
    dateTo = document.getElementById("dateTo");
    childrenEl = document.getElementById("children");
    roomTypeEl = document.getElementById("roomType");
    pkgLabel = document.getElementById("pkgLabel");
    pkgPrice = document.getElementById("pkgPrice");
    nightsVal = document.getElementById("nightsVal");
    peopleVal = document.getElementById("peopleVal");
    totalVal = document.getElementById("totalVal");
    bookingModalEl = document.getElementById("bookingModal");
    bookingForm = document.getElementById("bookingForm");

    // Add event listeners for real-time calculation updates - يعيد الحساب فوراً
    if (dateFrom) {
        dateFrom.addEventListener("change", updateSummary);
        dateFrom.addEventListener("input", updateSummary);
        // Update check-out min date when check-in changes
        dateFrom.addEventListener("change", function() {
            if (dateTo && dateFrom.value) {
                const nextDay = new Date(dateFrom.value);
                nextDay.setDate(nextDay.getDate() + 1);
                dateTo.min = nextDay.toISOString().split('T')[0];
            }
        });
    }
    if (dateTo) {
        dateTo.addEventListener("change", updateSummary);
        dateTo.addEventListener("input", updateSummary);
    }
    if (childrenEl) {
        childrenEl.addEventListener("change", updateSummary);
        childrenEl.addEventListener("input", updateSummary);
        childrenEl.addEventListener("keyup", updateSummary);
    }
}

/**
 * Setup all booking event listeners
 */
function setupBookingEventListeners() {
    const bookingButtons = document.querySelectorAll(".booking-btn");

    // Add event listeners to all booking buttons
    bookingButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const packageName = this.getAttribute("data-package");
            const price = this.getAttribute("data-price");
            const ratePlanId = this.getAttribute("data-rate-plan-id");

            // Extract rate plan data from the page
            extractRatePlanData(this, packageName, price, ratePlanId);

            // Update modal fields
            updatePackageDetails();

            // Show modal
            const modal = new bootstrap.Modal(
                document.getElementById("bookingModal")
            );
            modal.show();
        });
    });

    // Real-time summary updates
    [dateFrom, dateTo, childrenEl, roomTypeEl].forEach((el) => {
        if (el) {
            el.addEventListener("input", () => updateSummary());
        }
    });

    // Modal shown event
    if (bookingModalEl) {
        bookingModalEl.addEventListener("shown.bs.modal", () =>
            updateSummary()
        );
    }

    // Form submission
    if (bookingForm) {
        bookingForm.addEventListener("submit", handleFormSubmission);
    }
}

/**
 * Setup payment method event listeners
 */
function setupPaymentMethodListeners() {
    // Payment type selection
    document.querySelectorAll('input[name="payment_type"]').forEach((radio) => {
        radio.addEventListener("change", function () {
            showPaymentInstructions(this.value);
        });
    });
}

/**
 * Extract rate plan data from the clicked button's context
 */
function extractRatePlanData(button, packageName, price, ratePlanId) {
    const ratePlanCard = button.closest(".season-card");

    if (ratePlanCard) {
        const rateTitle = ratePlanCard.querySelector(".rate-title");
        const rateTitleText = rateTitle ? rateTitle.textContent.trim() : "";

        // Get board type
        const boardTypeElement = ratePlanCard.querySelector(
            ".text-end .text-primary-strong"
        );

        // Get transportation
        const allRateRows = ratePlanCard.querySelectorAll(".rate-row");
        let transportationElement = null;
        allRateRows.forEach((row) => {
            const primaryElement = row.querySelector(".text-primary");
            if (primaryElement) {
                transportationElement = primaryElement;
            }
        });

        // Get details
        const detailsRow = ratePlanCard.querySelector(".rate-row .muted.small");

        // Get room type
        const roomTypeRow = ratePlanCard.querySelector(".rate-row .muted");

        selectedRatePlan = {
            id: ratePlanId || "",
            name: packageName,
            price: price,
            startDate: rateTitleText.includes("—")
                ? rateTitleText.split("—")[0]?.trim()
                : "Available Now",
            endDate: rateTitleText.includes("—")
                ? rateTitleText.split("—")[1]?.trim()
                : "Flexible",
            boardType: boardTypeElement
                ? boardTypeElement.textContent.trim()
                : "All Inclusive",
            transportation: transportationElement
                ? transportationElement.textContent.trim()
                : "Included",
            details: detailsRow
                ? detailsRow.textContent.trim()
                : packageName + " package details",
            roomType: roomTypeRow
                ? roomTypeRow.textContent.replace(" Room", "").trim()
                : "Standard",
        };
    } else {
        // Fallback if card structure is different
        selectedRatePlan = {
            id: ratePlanId || "",
            name: packageName,
            price: price,
            startDate: "Available Now",
            endDate: "Flexible",
            boardType: "All Inclusive",
            transportation: "Included",
            details: packageName + " package details",
            roomType: "Standard",
        };
    }
}

/**
 * Update package details in the modal
 */
function updatePackageDetails() {
    if (selectedRatePlan) {
        // Update Package Details section
        const elements = {
            pkgLabel: document.getElementById("pkgLabel"),
            pkgPrice: document.getElementById("pkgPrice"),
            pkgBoardType: document.getElementById("pkgBoardType"),
            pkgStartDate: document.getElementById("pkgStartDate"),
            pkgEndDate: document.getElementById("pkgEndDate"),
            pkgTransportation: document.getElementById("pkgTransportation"),
            pkgDetails: document.getElementById("pkgDetails"),
        };

        if (elements.pkgLabel)
            elements.pkgLabel.textContent = selectedRatePlan.name || "Package";
        if (elements.pkgPrice)
            elements.pkgPrice.textContent = "USD " + selectedRatePlan.price;
        if (elements.pkgBoardType)
            elements.pkgBoardType.textContent =
                selectedRatePlan.boardType || "All Inclusive";
        if (elements.pkgStartDate)
            elements.pkgStartDate.textContent =
                selectedRatePlan.startDate || "Available Now";
        if (elements.pkgEndDate)
            elements.pkgEndDate.textContent =
                selectedRatePlan.endDate || "Flexible";
        if (elements.pkgTransportation)
            elements.pkgTransportation.textContent =
                selectedRatePlan.transportation || "Included";
        if (elements.pkgDetails)
            elements.pkgDetails.textContent =
                selectedRatePlan.details || "Package details";

        // Set the hidden rate plan ID
        const ratePlanIdField = document.getElementById("ratePlanId");
        if (ratePlanIdField) {
            ratePlanIdField.value = selectedRatePlan.id || "";
        }

        console.log("Updated package details:", selectedRatePlan);
    }
}

/**
 * Navigate between booking steps
 */
function goToStep(stepNumber) {
    // Hide all steps
    document.querySelectorAll(".step-section").forEach((step) => {
        step.style.display = "none";
    });

    // Show current step
    const currentStep = document.getElementById("step" + stepNumber);
    if (currentStep) {
        currentStep.style.display = "block";
    }

    // Validate step 1 before proceeding
    if (stepNumber === 2) {
        const name = document.getElementById("step1CustName").value.trim();
        const phone = document.getElementById("step1CustPhone").value.trim();

        if (!name || !phone) {
            alert("Please enter name and phone number");
            goToStep(1);
            return;
        }

        // Copy data from step 1 to hidden fields for form submission
        copyCustomerDataToForm();
    }
}

/**
 * Copy customer data from step 1 to form fields
 */
function copyCustomerDataToForm() {
    const step1Name = document.getElementById("step1CustName").value;
    const step1Phone = document.getElementById("step1CustPhone").value;
    const step1Email = document.getElementById("step1CustEmail").value;

    // Create hidden fields if they don't exist
    let nameField = document.getElementById("custName");
    if (!nameField) {
        nameField = document.createElement("input");
        nameField.type = "hidden";
        nameField.id = "custName";
        nameField.name = "customer_name";
        document.getElementById("bookingForm").appendChild(nameField);
    }

    let phoneField = document.getElementById("custPhone");
    if (!phoneField) {
        phoneField = document.createElement("input");
        phoneField.type = "hidden";
        phoneField.id = "custPhone";
        phoneField.name = "customer_phone";
        document.getElementById("bookingForm").appendChild(phoneField);
    }

    let emailField = document.getElementById("custEmail");
    if (!emailField) {
        emailField = document.createElement("input");
        emailField.type = "hidden";
        emailField.id = "custEmail";
        emailField.name = "customer_email";
        document.getElementById("bookingForm").appendChild(emailField);
    }

    nameField.value = step1Name;
    phoneField.value = step1Phone;
    emailField.value = step1Email;
}

/**
 * Select payment type
 */
function selectPaymentType(type) {
    selectedPaymentType = type;

    // Remove active class from all cards
    document.querySelectorAll(".payment-card").forEach((card) => {
        card.classList.remove("border-primary", "bg-light", "flash-effect");
    });

    // Add active class to selected card with flash effect
    const selectedCard = document.querySelector(
        `.payment-card[data-type="${type}"]`
    );
    if (selectedCard) {
        selectedCard.classList.add("border-primary", "bg-light", "flash-effect");
        
        // Remove flash effect after animation completes
        setTimeout(() => {
            selectedCard.classList.remove("flash-effect");
        }, 1500);
    }

    // Show next button
    const nextBtn = document.getElementById("nextToStep3");
    if (nextBtn) {
        nextBtn.style.display = "block";
    }

    // Update step 3 content based on selection
    const paymentOptions = document.getElementById("paymentOptions");
    const payNowBtn = document.getElementById("payNowBtn");

    if (type === "bank_transfer" || type === "instapay") {
        if (paymentOptions) paymentOptions.style.display = "block";
        if (payNowBtn) payNowBtn.style.display = "block";

        // Show payment instructions immediately
        showPaymentInstructions(type);
    }
}

/**
 * Show payment instructions for e-wallet
 */
function showPaymentInstructions(paymentType) {
    const totalAmount = calculateTotalAmount();
    const instructions = {
        bank_transfer: {
            title: "Bank Transfer Instructions",
            content: `
                <div class="alert alert-info">
                    <h6><i class="fas fa-university me-2"></i>Bank Account Details</h6>
                    <p><strong>Bank Name:</strong> National Bank of Egypt</p>
                    <p><strong>Account Name:</strong> Travel Company Ltd</p>
                    <p><strong>Account Number:</strong> 1234567890123456</p>
                    <p><strong>IBAN:</strong> EG380003000012345678901234</p>
                    <p><strong>Contact Phone:</strong> <span class="text-primary fw-bold">01151721654</span></p>
                    <p><strong>Required Amount:</strong> <span class="text-success fw-bold">${totalAmount} USE</span></p>
                </div>
                <hr>
                <p><strong>Transfer Steps:</strong></p>
                <ol>
                    <li>Visit your bank or use online banking</li>
                    <li>Transfer the exact amount to the account above</li>
                    <li>Call us at <strong>01151721654</strong> to confirm transfer</li>
                    <li>Keep the transfer receipt</li>
                    <li>Upload a clear photo of the receipt below</li>
                    <li>We will verify your payment within 24 hours</li>
                </ol>
            `,
        },
        instapay: {
            title: "InstaPay Transfer Instructions",
            content: `
                <div class="alert alert-success">
                    <h6><i class="fas fa-mobile-alt me-2"></i>InstaPay Details</h6>
                    <p><strong>InstaPay ID:</strong> TravelCompany@instapay</p>
                    <p><strong>Mobile Number:</strong> +20 100 123 4567</p>
                    <p><strong>Required Amount:</strong> <span class="text-success fw-bold">${totalAmount} USD</span></p>
                </div>
                <hr>
                <p><strong>Transfer Steps:</strong></p>
                <ol>
                    <li>Open your banking app</li>
                    <li>Select InstaPay transfer</li>
                    <li>Enter InstaPay ID: <code>TravelCompany@instapay</code></li>
                    <li>Enter amount: <strong>${totalAmount} USD</strong></li>
                    <li>Complete the transfer</li>
                    <li>Upload screenshot of successful transfer below</li>
                </ol>
            `,
        },
    };

    const instruction = instructions[paymentType];
    if (instruction) {
        const titleEl = document.getElementById("instructionTitle");
        const contentEl = document.getElementById("instructionContent");
        const instructionsEl = document.getElementById("paymentInstructions");
        const receiptEl = document.getElementById("receiptUploadSection");
        const payBtnEl = document.getElementById("payNowBtn");

        if (titleEl) titleEl.textContent = instruction.title;
        if (contentEl) contentEl.innerHTML = instruction.content;
        if (instructionsEl) instructionsEl.style.display = "block";
        if (receiptEl) receiptEl.style.display = "block";
        if (payBtnEl) payBtnEl.style.display = "block";
    }
}

/**
 * Calculate total amount for pricing display
 */
function calculateTotalAmount() {
    if (selectedRatePlan) {
        const basePrice = parseFloat(selectedRatePlan.price) || 0;
        const children =
            parseInt(document.getElementById("children")?.value) || 0;
        const nights = calculateNights();

        if (nights <= 0) return 0;

        // Base cost for 2 adults (included in package price)
        const baseCost = basePrice * nights;

        // Children pricing: ≤2 free, >2 = +$10 USD per extra child per night
        let childrenCost = 0;
        if (children > 2) {
            const extraChildren = children - 2;
            childrenCost = extraChildren * 10 * nights;
        }

        // Subtotal (no room upgrades since only standard room)
        const subtotal = baseCost + childrenCost;

        // No tax - final price is the subtotal
        const taxAmount = 0;
        const total = subtotal;

        return Math.round(total);
    }
    return 0;
}

/**
 * Calculate number of nights
 */
function calculateNights() {
    const checkIn = document.getElementById("dateFrom")?.value;
    const checkOut = document.getElementById("dateTo")?.value;

    if (!checkIn || !checkOut) return 1;

    const startDate = new Date(checkIn);
    const endDate = new Date(checkOut);
    const timeDiff = endDate.getTime() - startDate.getTime();
    const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));

    return nights > 0 ? nights : 1;
}

/**
 * Get room upgrade cost per night
 */
function getRoomUpgradeCost() {
    const roomTypeEl = document.getElementById("roomType");
    if (!roomTypeEl) return 0;

    const selectedOption = roomTypeEl.selectedOptions[0];
    return parseInt(selectedOption?.dataset.upgrade) || 0;
}

/**
 * Process payment based on selected method
 */
function processPayment() {
    // Ensure customer data is copied from step 1
    copyCustomerDataToForm();

    // Validate required fields
    const name = document.getElementById("custName")?.value?.trim();
    const phone = document.getElementById("custPhone")?.value?.trim();

    if (!name || !phone) {
        alert("Please enter all required customer information");
        goToStep(1);
        return;
    }

    // All payments now require receipt upload
    if (!selectedPaymentType) {
        alert("Please select a payment method");
        return;
    }

    if (
        selectedPaymentType === "bank_transfer" ||
        selectedPaymentType === "instapay"
    ) {
        const receiptFile = document.getElementById("receiptFile").files[0];

        if (!receiptFile) {
            alert("Please upload payment receipt");
            return;
        }
    }

    // Submit booking
    submitBooking();
}

/**
 * Compute nights between dates
 */
function computeNights() {
    if (!dateFrom?.value || !dateTo?.value) return 1;
    const from = new Date(dateFrom.value);
    const to = new Date(dateTo.value);
    const diff = Math.round((to - from) / (1000 * 60 * 60 * 24));
    return Math.max(1, diff);
}

/**
 * Calculate total for summary display
 */
function calculateTotal() {
    if (!selectedRatePlan) {
        return {
            nights: 1,
            children: 0,
            extraChildren: 0,
            total: 0,
        };
    }

    const base = parseFloat(selectedRatePlan.price) || 0;
    const children = parseInt(childrenEl?.value) || 0;
    const nights = computeNights();

    // Calculate costs - New pricing logic

    // Children pricing: ≤2 free, >2 = +$10 USD per extra child per night
    let childrenCost = 0;
    let extraChildren = 0;
    if (children > 2) {
        extraChildren = children - 2;
        childrenCost = extraChildren * 10 * nights; // $10 USD per extra child per night
    }

    // Base cost for 2 adults (included in package price)
    const baseCost = base * nights;

    const subtotal = baseCost + childrenCost;

    // No tax - final price is the subtotal
    const taxAmount = 0;
    const total = subtotal;

    return {
        nights,
        children,
        extraChildren,
        subtotal: Math.round(subtotal),
        taxAmount: Math.round(taxAmount),
        total: Math.round(total),
    };
}

/**
 * Update summary display
 */
function updateSummary() {
    const data = calculateTotal();

    if (nightsVal) nightsVal.textContent = data.nights;
    if (peopleVal) {
        let peopleText = ``;
        if (data.children > 0) {
            if (data.children <= 2) {
                peopleText = `${data.children} child(ren) (free)`;
            } else {
                peopleText = `${data.children} child(ren) (${data.extraChildren} extra @ $10 each)`;
            }
        } else {
            peopleText = `No children`;
        }
        peopleVal.textContent = peopleText;
    }
    // Get currency from selected rate plan or default to USD
    const currency = selectedRatePlan?.currency || "USD";
    const currencySymbol = currency === "USD" ? "$" : currency + " ";
    if (totalVal) totalVal.textContent = `${currencySymbol}${data.total}`;
}

/**
 * Handle form submission
 */
function handleFormSubmission(e) {
    e.preventDefault();

    // Basic validation
    const name = document.getElementById("custName").value.trim();
    const phone = document.getElementById("custPhone").value.trim();
    const checkIn = document.getElementById("dateFrom").value;
    const checkOut = document.getElementById("dateTo").value;

    if (!name) {
        showToast("Please enter your full name.", "error");
        return;
    }
    if (!phone) {
        showToast("Please enter your phone number.", "error");
        return;
    }
    if (!checkIn) {
        showToast("Please select check-in date.", "error");
        return;
    }
    
    // Validate check-in date is after today
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const checkInDate = new Date(checkIn);
    
    if (checkInDate <= today) {
        showToast("Check-in date must be after today.", "error");
        return;
    }
    
    if (!checkOut) {
        showToast("Please select check-out date.", "error");
        return;
    }
    
    // Validate check-out date is after check-in date
    const checkOutDate = new Date(checkOut);
    if (checkOutDate <= checkInDate) {
        showToast("Check-out date must be after check-in date.", "error");
        return;
    }

    // Check if payment method is selected
    if (!selectedPaymentType) {
        showToast("Please select a payment method.", "error");
        return;
    }

    // Submit the booking
    submitBooking();
}

/**
 * Submit booking to server
 */
function submitBooking() {
    // Get form data
    const formData = new FormData();

    // Add tour and rate plan data
    const tourId = document
        .querySelector("[data-tour-id]")
        ?.getAttribute("data-tour-id");
    const ratePlanId = selectedRatePlan?.id;

    if (!tourId) {
        showToast("Tour information is missing. Please refresh the page and try again.", "error");
        return;
    }

    if (!ratePlanId) {
        showToast("Please select a package first.", "error");
        return;
    }

    formData.append("tour_id", tourId);
    formData.append("rate_plan_id", ratePlanId);

    // Add customer information
    formData.append(
        "customer_name",
        document.getElementById("custName").value.trim()
    );
    formData.append(
        "customer_phone",
        document.getElementById("custPhone").value.trim()
    );
    formData.append(
        "customer_email",
        document.getElementById("custEmail").value.trim()
    );

    // Add booking details
    formData.append("check_in_date", document.getElementById("dateFrom").value);
    formData.append("check_out_date", document.getElementById("dateTo").value);
    formData.append("children", document.getElementById("children").value || 0);
    formData.append(
        "room_type",
        document.getElementById("roomType").value || "standard"
    );
    formData.append(
        "special_requests",
        document.getElementById("specialRequests").value || ""
    );

    // Add payment information
    formData.append("payment_method", selectedPaymentType);

    // Add receipt image if uploaded
    const receiptInput = document.getElementById("receiptUpload");
    if (receiptInput && receiptInput.files[0]) {
        formData.append("receipt_image", receiptInput.files[0]);
    }

    // Add CSRF token
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");
    if (csrfToken) {
        formData.append("_token", csrfToken);
    }

    // Show loading state
    const submitBtn = document.querySelector("#bookingModal .btn-primary");
    const originalText = submitBtn?.textContent;
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = "Processing...";
    }

    // Submit to server
    fetch("/interface/book", {
        method: "POST",
        body: formData,
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Show success toast
                showToast(
                    ` Booking Successful! Reference: ${data.booking_reference}`,
                    "success",
                    8000
                );

                // Close modal
                const modal = bootstrap.Modal.getInstance(
                    document.getElementById("bookingModal")
                );
                if (modal) {
                    modal.hide();
                }

                // Reset form
                document.getElementById("bookingForm")?.reset();
                goToStep(1);
            } else {
                // Show error toast
                let errorMessage =
                    data.message ||
                    "An error occurred while processing your booking.";

                if (data.errors) {
                    const errorList = [];
                    Object.keys(data.errors).forEach((field) => {
                        errorList.push(...data.errors[field]);
                    });
                    errorMessage = errorList.join(", ");
                }

                showToast(errorMessage, "error", 6000);
            }
        })
        .catch((error) => {
            console.error("Booking submission error:", error);
            showToast(
                "Network error occurred. Please check your connection and try again.",
                "error",
                6000
            );
        })
        .finally(() => {
            // Reset button state
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });
}

/**
 * Quick booking function for buttons without specific package
 */
function openBookingQuick(packageType = "default") {
    const firstBookingBtn = document.querySelector(".booking-btn");
    if (firstBookingBtn) {
        firstBookingBtn.click();
    } else {
        // Create a default rate plan if no packages available
        selectedRatePlan = {
            id: "",
            name: "Standard Package",
            price: "2000",
            startDate: "Available Now",
            endDate: "Flexible",
            boardType: "All Inclusive",
            transportation: "Included",
            details: "Standard package with all amenities",
            roomType: "Standard",
        };

        updatePackageDetails();

        // Show modal
        const modal = new bootstrap.Modal(
            document.getElementById("bookingModal")
        );
        modal.show();
    }
}

// Make functions globally available
window.goToStep = goToStep;
window.selectPaymentType = selectPaymentType;
window.processPayment = processPayment;
window.openBookingQuick = openBookingQuick;
