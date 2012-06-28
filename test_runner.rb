require 'rubygems'

require 'listen'

cont = true

puts "Watching src/{main,test}/php/**/*.php for changes"
puts "---"
puts `php -d error_reporting=E_ALL src/test/php/index.php`
puts "---"

callback = Proc.new do |modified, added, removed|
  puts `php -d error_reporting=E_ALL src/test/php/index.php`
  puts "---"
end

listener = Listen.to('src')
listener = listener.filter(/\.php$/)
listener.change(&callback)

Signal.trap("SIGINT") do
  listener.stop
  cont = false
  puts ""
end

listener.start(false)

while cont do
  sleep 1
end
