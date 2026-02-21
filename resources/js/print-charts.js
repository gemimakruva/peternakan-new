/**
 * Print Charts Handler
 * Converts Chart.js canvases to images for PDF printing
 */

(function() {
    'use strict';

    // Store original canvas states
    let chartImages = [];
    let isConverted = false;

    /**
     * Convert all Chart.js canvases to images
     */
    function convertChartsToImages() {
        if (isConverted) return;

        chartImages = [];
        
        document.querySelectorAll('canvas').forEach(canvas => {
            try {
                // Check if canvas has content (Chart.js renders on it)
                if (canvas.width > 0 && canvas.height > 0) {
                    const img = document.createElement('img');
                    img.src = canvas.toDataURL('image/png');
                    img.className = 'print-chart-img';
                    img.style.width = '100%';
                    img.style.maxWidth = canvas.offsetWidth + 'px';
                    img.style.height = 'auto';
                    img.setAttribute('data-canvas-id', canvas.id || '');
                    
                    // Insert image before canvas
                    canvas.parentNode.insertBefore(img, canvas);
                    
                    // Hide canvas
                    canvas.classList.add('d-none');
                    canvas.style.display = 'none';
                    
                    chartImages.push({
                        canvas: canvas,
                        img: img
                    });
                }
            } catch(e) {
                console.warn('Could not convert chart to image:', e);
            }
        });

        isConverted = true;
    }

    /**
     * Restore all canvases (remove images)
     */
    function restoreCharts() {
        if (!isConverted) return;

        chartImages.forEach(item => {
            // Remove the image
            if (item.img && item.img.parentNode) {
                item.img.parentNode.removeChild(item.img);
            }
            
            // Show canvas again
            if (item.canvas) {
                item.canvas.classList.remove('d-none');
                item.canvas.style.display = '';
            }
        });

        chartImages = [];
        isConverted = false;
    }

    /**
     * Print the report
     */
    function printReport() {
        convertChartsToImages();
        
        // Small delay to ensure images are rendered
        setTimeout(() => {
            window.print();
            
            // Restore after print dialog closes
            setTimeout(restoreCharts, 100);
        }, 300);
    }

    /**
     * Get chart images as data URLs (for server-side PDF generation)
     */
    function getChartImages() {
        const images = {};
        
        document.querySelectorAll('canvas').forEach(canvas => {
            if (canvas.id && canvas.width > 0 && canvas.height > 0) {
                try {
                    images[canvas.id] = canvas.toDataURL('image/png');
                } catch(e) {
                    console.warn('Could not get chart image:', canvas.id, e);
                }
            }
        });

        return images;
    }

    /**
     * Get filter values for print display
     */
    function getFilterValues() {
        const filters = {};
        
        // Get select values
        document.querySelectorAll('select[name]').forEach(select => {
            const selectedOption = select.options[select.selectedIndex];
            filters[select.name] = {
                value: select.value,
                label: selectedOption ? selectedOption.text : select.value
            };
        });

        // Get input values
        document.querySelectorAll('input[name][type="text"], input[name][type="number"]').forEach(input => {
            filters[input.name] = {
                value: input.value,
                label: input.value
            };
        });

        return filters;
    }

    // Listen for browser print events
    window.addEventListener('beforeprint', convertChartsToImages);
    window.addEventListener('afterprint', restoreCharts);

    // Expose functions globally
    window.PrintCharts = {
        convert: convertChartsToImages,
        restore: restoreCharts,
        print: printReport,
        getImages: getChartImages,
        getFilters: getFilterValues
    };

})();
