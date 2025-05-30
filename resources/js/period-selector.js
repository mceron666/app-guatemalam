// Global variable to store the selected period
let selectedPeriod = null

// Function to initialize the period selector
function initPeriodSelector(periods) {
  // Find the target element to position the selector above
  const adminTitle = document.querySelector('.navbar-section-title:contains("Administración")')

  if (!adminTitle) return

  // Create the period selector dropdown
  const periodSelector = document.createElement("div")
  periodSelector.className = "period-selector"

  // Sort periods by ID (assuming higher ID is more recent)
  const sortedPeriods = [...periods].sort((a, b) => b.ID_PERIODO_ESCOLAR - a.ID_PERIODO_ESCOLAR)

  // Set the first period as default selected
  selectedPeriod = sortedPeriods[0]

  // Create the dropdown HTML
  periodSelector.innerHTML = `
    <div class="period-dropdown">
      <button class="period-button">
        <i class="fas fa-calendar-alt"></i>
        <span class="period-text">${selectedPeriod.CODIGO_PERIODO}</span>
        <i class="fas fa-chevron-down"></i>
      </button>
      <div class="period-dropdown-content">
        ${sortedPeriods
          .map(
            (period) => `
          <div class="period-item" data-id="${period.ID_PERIODO_ESCOLAR}">
            ${period.CODIGO_PERIODO}
          </div>
        `,
          )
          .join("")}
      </div>
    </div>
  `

  // Insert the selector before the admin title
  adminTitle.parentNode.insertBefore(periodSelector, adminTitle)

  // Add event listeners
  const dropdownButton = periodSelector.querySelector(".period-button")
  const dropdownContent = periodSelector.querySelector(".period-dropdown-content")
  const periodItems = periodSelector.querySelectorAll(".period-item")

  // Toggle dropdown on button click
  dropdownButton.addEventListener("click", (e) => {
    e.stopPropagation()
    dropdownContent.classList.toggle("show")
  })

  // Handle period selection
  periodItems.forEach((item) => {
    item.addEventListener("click", function () {
      const periodId = Number.parseInt(this.dataset.id)
      const period = periods.find((p) => p.ID_PERIODO_ESCOLAR === periodId)

      if (period) {
        selectedPeriod = period
        dropdownButton.querySelector(".period-text").textContent = period.CODIGO_PERIODO
        dropdownContent.classList.remove("show")

        // Save to localStorage for persistence
        localStorage.setItem("selectedPeriod", JSON.stringify(period))

        // Dispatch custom event for other components to react
        document.dispatchEvent(
          new CustomEvent("periodChanged", {
            detail: { period },
          }),
        )
      }
    })
  })

  // Close dropdown when clicking outside
  document.addEventListener("click", () => {
    dropdownContent.classList.remove("show")
  })

  // Check if we have a previously selected period in localStorage
  const savedPeriod = localStorage.getItem("selectedPeriod")
  if (savedPeriod) {
    try {
      const parsedPeriod = JSON.parse(savedPeriod)
      const period = periods.find((p) => p.ID_PERIODO_ESCOLAR === parsedPeriod.ID_PERIODO_ESCOLAR)
      if (period) {
        selectedPeriod = period
        dropdownButton.querySelector(".period-text").textContent = period.CODIGO_PERIODO
      }
    } catch (e) {
      console.error("Error parsing saved period", e)
    }
  }
}

// Function to get the currently selected period
function getSelectedPeriod() {
  return selectedPeriod
}

// Initialize the selector when the page loads
document.addEventListener("DOMContentLoaded", () => {
  // Fetch periods from the API
  fetch("/periodos/seleccion")
    .then((response) => response.json())
    .then((periods) => {
      initPeriodSelector(periods)
    })
    .catch((error) => {
      console.error("Error fetching periods:", error)
    })
})

// For testing with static data
// const testPeriods = [
//   {
//     "ID_PERIODO_ESCOLAR": 54,
//     "CODIGO_PERIODO": "2025 - 2026",
//     "DESCRIPCION_PERIODO": "Período de 2025 a 2026"
//   },
//   {
//     "ID_PERIODO_ESCOLAR": 55,
//     "CODIGO_PERIODO": "2023 - 2024",
//     "DESCRIPCION_PERIODO": "Período de 2023 a 2024"
//   }
// ];
// initPeriodSelector(testPeriods);
